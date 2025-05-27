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

        $tickets = $customer->tickets()
            ->with(['responses.user', 'responses.adminUser', 'assignedTo', 'department'])
            ->latest()
            ->paginate(10);

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
        $customer = $request->user()->userable;

        $ticket = Ticket::create([
            'ticket_number' => 'TKT-' . strtoupper(Str::random(8)),
            'customer_id' => $customer->id,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'open',
            'priority' => $request->priority ?? 'normal',
            'category' => $request->category ?? 'general',
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

        return response()->json([
            'data' => $ticket,
            'message' => 'Support ticket created successfully.'
        ], 201);
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
