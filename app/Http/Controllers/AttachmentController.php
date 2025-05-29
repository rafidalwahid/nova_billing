<?php

namespace App\Http\Controllers;

use App\Models\TicketResponse;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function removeAttachment(Request $request, $responseId, $attachmentIndex)
    {
        \Log::info('RemoveAttachment called', [
            'responseId' => $responseId,
            'attachmentIndex' => $attachmentIndex,
            'user' => auth()->id()
        ]);

        $user = auth()->user();

        // Verify user is authenticated and is a customer
        if (!$user || !$user->isCustomer()) {
            \Log::warning('Access denied - not customer', ['user_id' => $user ? $user->id : null]);
            abort(403, 'Access denied - not a customer');
        }

        $response = TicketResponse::find($responseId);

        // Verify response exists and belongs to customer
        if (!$response ||
            $response->type !== TicketResponse::TYPE_CUSTOMER ||
            !$response->ticket ||
            $response->ticket->customer_id !== $user->userable->id) {
            \Log::warning('Access denied - response ownership', [
                'response_id' => $responseId,
                'response_exists' => !!$response,
                'response_type' => $response ? $response->type : null,
                'ticket_customer_id' => $response && $response->ticket ? $response->ticket->customer_id : null,
                'user_customer_id' => $user->userable->id ?? null
            ]);
            abort(403, 'Access denied - response ownership');
        }

        // Verify attachment exists
        if (!$response->attachments || !is_array($response->attachments) || !isset($response->attachments[$attachmentIndex])) {
            \Log::warning('Attachment not found', [
                'response_id' => $responseId,
                'attachment_index' => $attachmentIndex,
                'attachments_count' => $response->attachments ? count($response->attachments) : 0
            ]);
            return redirect()->back()->with('error', 'Attachment not found');
        }

        // Remove the attachment
        $attachments = $response->attachments;
        $removedAttachment = $attachments[$attachmentIndex];
        unset($attachments[$attachmentIndex]);
        $attachments = array_values($attachments); // Reindex

        $response->update(['attachments' => $attachments]);

        \Log::info('Attachment removed successfully', [
            'response_id' => $responseId,
            'removed_file' => $removedAttachment['original_name'] ?? 'Unknown'
        ]);

        // Redirect back to Nova resource detail page
        return redirect("/nova/resources/ticket-responses/{$responseId}")
            ->with('success', "Attachment '{$removedAttachment['original_name']}' removed successfully");
    }

    public function downloadAttachment(Request $request, $responseId, $attachmentIndex)
    {
        $user = auth()->user();

        // Verify user is authenticated and is admin/staff
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Access denied - admin only');
        }

        $response = TicketResponse::find($responseId);

        // Verify response exists
        if (!$response) {
            abort(404, 'Response not found');
        }

        // Verify attachment exists
        if (!$response->attachments || !is_array($response->attachments) || !isset($response->attachments[$attachmentIndex])) {
            abort(404, 'Attachment not found');
        }

        $attachment = $response->attachments[$attachmentIndex];
        $filePath = $attachment['file_path'] ?? null;
        $originalName = $attachment['original_name'] ?? 'download';

        if (!$filePath || !\Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found on disk');
        }

        // Return file download response
        return \Storage::disk('public')->download($filePath, $originalName);
    }
}
