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
     * Add a response to an existing ticket.
     *
     * @param AddTicketResponseRequest $request
     * @param int $ticketId
     * @return JsonResponse
     */
    public function addResponse(AddTicketResponseRequest $request, int $ticketId): JsonResponse
    {
        try {
            $customer = $request->user()->userable;
            $user = $request->user();

            // Get ticket with authorization check
            $ticket = $this->ticketService->getCustomerTicket($customer, $ticketId);

            // Add response using service
            $response = $this->ticketService->addCustomerResponse(
                $ticket,
                $user,
                $request->validated()['message']
            );

            return response()->json([
                'data' => $response,
                'message' => 'Response added successfully.'
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Ticket not found.',
                'message' => 'The requested ticket does not exist or you do not have permission to access it.'
            ], 404);

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
     * Upload attachment for a ticket (placeholder for future implementation).
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

            // File upload functionality placeholder - ready for future implementation
            return response()->json([
                'message' => 'File attachment functionality will be implemented in a future update.',
                'ticket_number' => $ticket->ticket_number,
                'supported_formats' => ['pdf', 'doc', 'docx', 'txt', 'jpg', 'png'],
                'max_size' => '10MB'
            ], 501); // 501 Not Implemented

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Ticket not found.',
                'message' => 'The requested ticket does not exist or you do not have permission to access it.'
            ], 404);
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
