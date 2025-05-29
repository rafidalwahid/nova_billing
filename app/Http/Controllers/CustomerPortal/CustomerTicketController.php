<?php

namespace App\Http\Controllers\CustomerPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerPortal\CreateTicketRequest;
use App\Http\Requests\CustomerPortal\AddTicketResponseRequest;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;


/**
 * Customer Ticket Controller - Optimized Version
 *
 * Handles customer-facing ticket operations with proper separation of concerns,
 * comprehensive error handling, and security best practices.
 */
class CustomerTicketController extends Controller
{
    /**
     * The ticket service instance.
     */
    protected TicketService $ticketService;

    /**
     * Create a new controller instance.
     *
     * @param TicketService $ticketService
     */
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Get customer support tickets with filtering and pagination.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $customer = $request->user()->userable;

            // Build filters from request
            $filters = $this->buildFiltersFromRequest($request);

            // Get per page limit (max 50 to prevent abuse)
            $perPage = min($request->get('per_page', 10), 50);

            // Get paginated tickets using service
            $tickets = $this->ticketService->getCustomerTickets($customer, $filters, $perPage);

            return response()->json([
                'data' => $tickets->items(),
                'meta' => [
                    'current_page' => $tickets->currentPage(),
                    'last_page' => $tickets->lastPage(),
                    'per_page' => $tickets->perPage(),
                    'total' => $tickets->total(),
                ],
                'links' => [
                    'first' => $tickets->url(1),
                    'last' => $tickets->url($tickets->lastPage()),
                    'prev' => $tickets->previousPageUrl(),
                    'next' => $tickets->nextPageUrl(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve customer tickets', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Unable to retrieve tickets at this time.',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    /**
     * Get specific ticket details with responses.
     *
     * @param Request $request
     * @param int $ticketId
     * @return JsonResponse
     */
    public function show(Request $request, int $ticketId): JsonResponse
    {
        try {
            $customer = $request->user()->userable;

            $ticket = $this->ticketService->getCustomerTicket($customer, $ticketId);

            return response()->json([
                'data' => $ticket
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Ticket not found.',
                'message' => 'The requested ticket does not exist or you do not have permission to view it.'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve customer ticket', [
                'user_id' => $request->user()->id,
                'ticket_id' => $ticketId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Unable to retrieve ticket at this time.',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    /**
     * Create a new support ticket.
     *
     * @param CreateTicketRequest $request
     * @return JsonResponse
     */
    public function store(CreateTicketRequest $request): JsonResponse
    {
        try {
            $customer = $request->user()->userable;
            $user = $request->user();

            // Create ticket using service
            $ticket = $this->ticketService->createCustomerTicket(
                $customer,
                $user,
                $request->validated()
            );

            return response()->json([
                'data' => $ticket,
                'message' => 'Support ticket created successfully.'
            ], 201);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => 'Invalid ticket data.',
                'message' => $e->getMessage()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Failed to create customer ticket', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->validated(),
            ]);

            return response()->json([
                'error' => 'Failed to create ticket.',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    /**
     * Get ticket responses.
     *
     * @param Request $request
     * @param int $ticketId
     * @return JsonResponse
     */
    public function getResponses(Request $request, int $ticketId): JsonResponse
    {
        try {
            $customer = $request->user()->userable;

            // Get ticket with authorization check
            $ticket = $this->ticketService->getCustomerTicket($customer, $ticketId);

            // Get responses using service
            $responses = $this->ticketService->getTicketResponses($ticket);

            return response()->json([
                'data' => $responses
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Ticket not found.',
                'message' => 'The requested ticket does not exist or you do not have permission to view it.'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve ticket responses', [
                'user_id' => $request->user()->id,
                'ticket_id' => $ticketId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Unable to retrieve responses at this time.',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    /**
     * Add a response to an existing ticket (with optional attachment).
     *
     * @param Request $request
     * @param int $ticketId
     * @return JsonResponse
     */
    public function addResponse(Request $request, int $ticketId): JsonResponse
    {
        try {
            $customer = $request->user()->userable;
            $user = $request->user();

            // Validate request
            $request->validate([
                'message' => 'required|string|min:5|max:1000',
                'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip'
            ]);

            // Get ticket with authorization check
            $ticket = $this->ticketService->getCustomerTicket($customer, $ticketId);

            // Add response using service
            $response = $this->ticketService->addCustomerResponse(
                $ticket,
                $user,
                $request->input('message')
            );

            // Handle file attachment if provided
            if ($request->hasFile('attachment')) {
                $fileUploadService = app(\App\Services\FileUploadService::class);
                $attachment = $fileUploadService->uploadTicketAttachment(
                    $request->file('attachment'),
                    $ticket->id
                );

                // Add attachment to response
                $response->update(['attachments' => [$attachment]]);
            }

            return response()->json([
                'data' => $response->load(['user', 'ticket']),
                'message' => 'Response added successfully.'
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Ticket not found.',
                'message' => 'The requested ticket does not exist or you do not have permission to access it.'
            ], 404);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => 'Cannot add response.',
                'message' => $e->getMessage()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Failed to add ticket response', [
                'user_id' => $request->user()->id,
                'ticket_id' => $ticketId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Failed to add response.',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    /**
     * Upload attachment for a ticket.
     *
     * @param Request $request
     * @param int $ticketId
     * @return JsonResponse
     */
    public function uploadAttachment(Request $request, int $ticketId): JsonResponse
    {
        try {
            $customer = $request->user()->userable;

            // Verify ticket exists and customer has access
            $ticket = $this->ticketService->getCustomerTicket($customer, $ticketId);

            // Validate file upload
            $request->validate([
                'file' => [
                    'required',
                    'file',
                    'max:10240', // 10MB in KB
                    'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip'
                ],
                'response_message' => 'nullable|string|max:1000'
            ]);

            // Upload file using service
            $fileUploadService = app(\App\Services\FileUploadService::class);
            $uploadResult = $fileUploadService->uploadTicketAttachment(
                $request->file('file'),
                $ticket->id
            );

            // If response message is provided, create a response with the attachment
            if ($request->filled('response_message')) {
                $response = $this->ticketService->addCustomerResponse(
                    $ticket,
                    $request->user(),
                    $request->input('response_message')
                );

                // Add attachment to the response
                $response->update(['attachments' => [$uploadResult]]);

                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded and response added successfully.',
                    'ticket_number' => $ticket->ticket_number,
                    'response_id' => $response->id,
                    'attachment' => $uploadResult
                ]);
            }

            // Just upload the file without creating a response
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully.',
                'ticket_number' => $ticket->ticket_number,
                'attachment' => $uploadResult
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Ticket not found.',
                'ticket_id' => $ticketId
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'File validation failed.',
                'validation_errors' => $e->errors()
            ], 422);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'ticket_number' => $ticket->ticket_number ?? null
            ], 400);
        } catch (\Exception $e) {
            \Log::error('File upload failed', [
                'ticket_id' => $ticketId,
                'customer_id' => $customer->id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'File upload failed. Please try again.',
                'ticket_id' => $ticketId
            ], 500);
        }
    }

    /**
     * Download attachment for a customer's ticket response.
     *
     * @param Request $request
     * @param int $responseId
     * @param int $attachmentIndex
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadAttachment(Request $request, int $responseId, int $attachmentIndex)
    {
        try {
            $customer = $request->user()->userable;

            // Find the response
            $response = \App\Models\TicketResponse::findOrFail($responseId);

            // Verify customer has access to this response
            if (!$response->ticket || $response->ticket->customer_id !== $customer->id) {
                abort(403, 'Access denied - you do not have permission to access this attachment.');
            }

            // Verify attachment exists
            if (!$response->attachments ||
                !is_array($response->attachments) ||
                !isset($response->attachments[$attachmentIndex])) {
                abort(404, 'Attachment not found.');
            }

            $attachment = $response->attachments[$attachmentIndex];
            $filePath = $attachment['file_path'] ?? null;
            $originalName = $attachment['original_name'] ?? 'download';

            if (!$filePath || !\Storage::disk('public')->exists($filePath)) {
                abort(404, 'File not found on disk.');
            }

            // Return file download response
            return \Storage::disk('public')->download($filePath, $originalName);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Response not found.');
        } catch (\Exception $e) {
            \Log::error('Customer attachment download failed', [
                'response_id' => $responseId,
                'attachment_index' => $attachmentIndex,
                'customer_id' => $customer->id ?? null,
                'error' => $e->getMessage()
            ]);

            abort(500, 'Download failed. Please try again.');
        }
    }

    /**
     * Get attachments for a customer's ticket response.
     *
     * @param Request $request
     * @param int $responseId
     * @return JsonResponse
     */
    public function getAttachments(Request $request, int $responseId): JsonResponse
    {
        try {
            $customer = $request->user()->userable;

            // Find the response
            $response = \App\Models\TicketResponse::findOrFail($responseId);

            // Verify customer has access to this response
            if (!$response->ticket || $response->ticket->customer_id !== $customer->id) {
                return response()->json([
                    'error' => 'Access denied - you do not have permission to access this response.'
                ], 403);
            }

            // Get attachment information
            $fileUploadService = app(\App\Services\FileUploadService::class);
            $attachments = [];

            if ($response->attachments && is_array($response->attachments)) {
                foreach ($response->attachments as $index => $attachment) {
                    $attachmentInfo = $fileUploadService->getAttachmentInfo($attachment);
                    $attachmentInfo['index'] = $index;
                    $attachmentInfo['download_url'] = route('customer-portal.tickets.download-attachment', [
                        'response' => $responseId,
                        'index' => $index
                    ]);
                    $attachments[] = $attachmentInfo;
                }
            }

            return response()->json([
                'success' => true,
                'response_id' => $responseId,
                'ticket_number' => $response->ticket->ticket_number,
                'attachments' => $attachments,
                'total_attachments' => count($attachments)
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Response not found.'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Customer attachment list failed', [
                'response_id' => $responseId,
                'customer_id' => $customer->id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to retrieve attachments. Please try again.'
            ], 500);
        }
    }

    /**
     * Build filters array from request parameters.
     *
     * @param Request $request
     * @return array
     */
    private function buildFiltersFromRequest(Request $request): array
    {
        $filters = [];

        // Search filter
        if ($request->filled('search')) {
            $filters['search'] = $request->get('search');
        }

        // Status filter
        if ($request->filled('status')) {
            $filters['status'] = $request->get('status');
        }

        // Category filter
        if ($request->filled('category')) {
            $filters['category'] = $request->get('category');
        }

        // Priority filter
        if ($request->filled('priority')) {
            $filters['priority'] = $request->get('priority');
        }

        return $filters;
    }
}
