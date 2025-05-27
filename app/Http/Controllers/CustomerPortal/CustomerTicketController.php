<?php

namespace App\Http\Controllers\CustomerPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerPortal\CreateTicketRequest;
use App\Http\Requests\CustomerPortal\AddTicketResponseRequest;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CustomerTicketController extends Controller
{
    /**
     * Get customer support tickets.
     */
    public function index(Request $request): JsonResponse
    {
        $customer = $request->user()->userable;

        $query = $customer->tickets()
            ->with(['responses.user', 'responses.adminUser', 'assignedTo', 'department']);

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('ticket_number', 'like', "%{$searchTerm}%")
                  ->orWhere('subject', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply priority filter
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Validate sort fields
        $allowedSortFields = ['created_at', 'updated_at', 'subject', 'status', 'priority', 'last_response_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->latest();
        }

        // Get per page limit
        $perPage = min($request->get('per_page', 10), 50); // Max 50 per page

        $tickets = $query->paginate($perPage);

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
    }

    /**
     * Get specific ticket details with responses.
     */
    public function show(Request $request, int $ticketId): JsonResponse
    {
        $customer = $request->user()->userable;

        $ticket = $customer->tickets()
            ->with([
                'responses.user',
                'responses.adminUser',
                'assignedTo',
                'department',
                'customer'
            ])
            ->findOrFail($ticketId);

        return response()->json([
            'data' => $ticket
        ]);
    }

    /**
     * Create a new support ticket.
     */
    public function store(CreateTicketRequest $request): JsonResponse
    {
        try {
            $customer = $request->user()->userable;

            // Log the incoming request for debugging
            \Log::info('Ticket Creation Request', [
                'user_id' => $request->user()->id,
                'customer_id' => $customer->id,
                'request_data' => $request->all(),
            ]);

            // Handle both 'category' (direct) and 'department' (from Nova tool) fields
            $category = $request->category ?? $request->department ?? 'general';

            // Map priority values (Nova tool uses 'medium', database uses 'normal')
            $priority = $request->priority;
            if ($priority === 'medium') {
                $priority = 'normal';
            }

            $ticket = Ticket::create([
                'ticket_number' => 'TKT-' . strtoupper(Str::random(8)),
                'customer_id' => $customer->id,
                'subject' => $request->subject,
                'description' => $request->description,
                'status' => 'open',
                'priority' => $priority ?? 'normal',
                'category' => $category,
                'source' => 'customer_portal',
            ]);

            // Create initial customer response
            TicketResponse::create([
                'ticket_id' => $ticket->id,
                'user_id' => $request->user()->id,
                'type' => 'customer',
                'message' => $request->description,
                'is_internal' => false,
            ]);

            $ticket->load(['responses.user', 'responses.adminUser', 'assignedTo', 'department']);

            \Log::info('Ticket Created Successfully', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
            ]);

            return response()->json([
                'data' => $ticket,
                'message' => 'Support ticket created successfully.'
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Ticket Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'error' => 'Failed to create ticket',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add a response to an existing ticket.
     */
    public function addResponse(AddTicketResponseRequest $request, int $ticketId): JsonResponse
    {
        $customer = $request->user()->userable;

        $ticket = $customer->tickets()->findOrFail($ticketId);

        // Don't allow responses to closed tickets
        if ($ticket->status === 'closed') {
            return response()->json([
                'message' => 'Cannot add responses to closed tickets.'
            ], 422);
        }

        $response = TicketResponse::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'type' => 'customer',
            'message' => $request->message,
            'is_internal' => false,
        ]);

        // Update ticket status if it was resolved
        if ($ticket->status === 'resolved') {
            $ticket->update(['status' => 'in_progress']);
        }

        $response->load(['user', 'adminUser']);

        return response()->json([
            'data' => $response,
            'message' => 'Response added successfully.'
        ], 201);
    }

    /**
     * Upload attachment for a ticket (placeholder for future implementation).
     */
    public function uploadAttachment(Request $request, int $ticketId): JsonResponse
    {
        $customer = $request->user()->userable;

        $ticket = $customer->tickets()->findOrFail($ticketId);

        // TODO: Implement file upload functionality
        return response()->json([
            'message' => 'File attachment functionality will be implemented in a future update.',
            'ticket_number' => $ticket->ticket_number
        ], 501); // 501 Not Implemented
    }
}
