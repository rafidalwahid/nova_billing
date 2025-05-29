<?php

namespace App\Services;

use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AttachmentService
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Add attachment to a ticket response.
     *
     * @param TicketResponse $response
     * @param UploadedFile $file
     * @param User $user
     * @return array
     * @throws \Exception
     */
    public function addAttachment(TicketResponse $response, UploadedFile $file, User $user): array
    {
        // Verify user can modify this response
        $this->verifyUserCanModifyResponse($response, $user);

        // Upload file using existing service
        $attachmentData = $this->fileUploadService->uploadTicketAttachment($file, $response->ticket_id);

        // Get current attachments
        $currentAttachments = $response->attachments ?? [];

        // Add new attachment
        $currentAttachments[] = $attachmentData;

        // Update response
        $response->update(['attachments' => $currentAttachments]);

        Log::info('Attachment added to ticket response', [
            'response_id' => $response->id,
            'ticket_id' => $response->ticket_id,
            'user_id' => $user->id,
            'filename' => $attachmentData['original_name'],
        ]);

        return $attachmentData;
    }

    /**
     * Remove attachment from a ticket response.
     *
     * @param TicketResponse $response
     * @param string $filename
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function removeAttachment(TicketResponse $response, string $filename, User $user): bool
    {
        // Verify user can modify this response
        $this->verifyUserCanModifyResponse($response, $user);

        $currentAttachments = $response->attachments ?? [];
        $updatedAttachments = [];
        $fileRemoved = false;

        foreach ($currentAttachments as $attachment) {
            if (($attachment['original_name'] ?? '') === $filename) {
                // Delete physical file
                if (isset($attachment['file_path'])) {
                    $this->fileUploadService->deleteTicketAttachment($attachment['file_path']);
                }
                $fileRemoved = true;
                continue;
            }
            $updatedAttachments[] = $attachment;
        }

        if (!$fileRemoved) {
            throw new \InvalidArgumentException("Attachment '{$filename}' not found.");
        }

        // Update response
        $response->update(['attachments' => $updatedAttachments]);

        Log::info('Attachment removed from ticket response', [
            'response_id' => $response->id,
            'ticket_id' => $response->ticket_id,
            'user_id' => $user->id,
            'filename' => $filename,
        ]);

        return true;
    }

    /**
     * Get available attachments for removal (for dropdown display).
     *
     * @param TicketResponse $response
     * @return array
     */
    public function getAvailableAttachments(TicketResponse $response): array
    {
        $attachments = $response->attachments ?? [];
        $options = [];

        foreach ($attachments as $attachment) {
            $name = $attachment['original_name'] ?? 'Unknown';
            $size = isset($attachment['file_size']) ? 
                FileUploadService::formatFileSize($attachment['file_size']) : '';
            $displayName = $name . ($size ? " ({$size})" : '');
            $options[$name] = $displayName;
        }

        return $options;
    }

    /**
     * Verify user can modify the response.
     *
     * @param TicketResponse $response
     * @param User $user
     * @throws \Exception
     */
    protected function verifyUserCanModifyResponse(TicketResponse $response, User $user): void
    {
        // Load ticket relationship if not loaded
        if (!$response->relationLoaded('ticket')) {
            $response->load('ticket');
        }

        // Customers can only modify their own responses to their own tickets
        if ($user->isCustomer()) {
            // Check if this is customer's ticket
            if ($response->ticket->customer_id !== $user->userable_id) {
                throw new \Exception('Access denied: You can only modify responses to your own tickets.');
            }

            // Check if this is customer's response
            if ($response->type !== \App\Models\TicketResponse::TYPE_CUSTOMER || 
                $response->user_id !== $user->id) {
                throw new \Exception('Access denied: You can only modify your own responses.');
            }
        }

        // Staff can modify any response (handled by policies)
        if (!$user->isCustomer() && !$user->can('update', $response)) {
            throw new \Exception('Access denied: Insufficient permissions to modify this response.');
        }
    }

    /**
     * Get attachment download URL.
     *
     * @param TicketResponse $response
     * @param string $filename
     * @param User $user
     * @return string
     * @throws \Exception
     */
    public function getAttachmentDownloadUrl(TicketResponse $response, string $filename, User $user): string
    {
        // Verify user can access this response
        $this->verifyUserCanAccessResponse($response, $user);

        $attachments = $response->attachments ?? [];
        
        foreach ($attachments as $attachment) {
            if (($attachment['original_name'] ?? '') === $filename) {
                return $this->fileUploadService->getDownloadUrl($attachment['file_path']);
            }
        }

        throw new \InvalidArgumentException("Attachment '{$filename}' not found.");
    }

    /**
     * Verify user can access the response.
     *
     * @param TicketResponse $response
     * @param User $user
     * @throws \Exception
     */
    protected function verifyUserCanAccessResponse(TicketResponse $response, User $user): void
    {
        // Load ticket relationship if not loaded
        if (!$response->relationLoaded('ticket')) {
            $response->load('ticket');
        }

        // Customers can only access responses to their own tickets
        if ($user->isCustomer()) {
            if ($response->ticket->customer_id !== $user->userable_id) {
                throw new \Exception('Access denied: You can only access responses to your own tickets.');
            }
        }

        // Staff access handled by policies
        if (!$user->isCustomer() && !$user->can('view', $response)) {
            throw new \Exception('Access denied: Insufficient permissions to access this response.');
        }
    }
}
