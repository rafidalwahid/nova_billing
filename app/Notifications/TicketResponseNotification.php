<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $response;
    protected $isCustomerResponse;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, TicketResponse $response, bool $isCustomerResponse = false)
    {
        $this->ticket = $ticket;
        $this->response = $response;
        $this->isCustomerResponse = $isCustomerResponse;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->isCustomerResponse
            ? "New Customer Response - Ticket #{$this->ticket->ticket_number}"
            : "New Staff Response - Ticket #{$this->ticket->ticket_number}";

        $greeting = $this->isCustomerResponse
            ? "Hello {$notifiable->first_name},"
            : "Hello {$notifiable->name},";

        $message = $this->isCustomerResponse
            ? "A new response has been added to your support ticket."
            : "Our support team has responded to your ticket.";

        $actionText = $this->isCustomerResponse
            ? "View Ticket in Admin Panel"
            : "View My Ticket";

        $actionUrl = $this->isCustomerResponse
            ? url("/nova/resources/tickets/{$this->ticket->id}")
            : url("/nova/resources/customer-tickets/{$this->ticket->id}");

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($message)
            ->line("**Ticket:** {$this->ticket->formatted_ticket_number}")
            ->line("**Subject:** {$this->ticket->subject}")
            ->line("**Status:** " . ucfirst($this->ticket->status))
            ->line("**Response Preview:** " . \Str::limit($this->response->message, 100))
            ->action($actionText, $actionUrl)
            ->line('Thank you for using our support system!');
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'response_id' => $this->response->id,
            'subject' => $this->ticket->subject,
            'message' => \Str::limit($this->response->message, 100),
            'is_customer_response' => $this->isCustomerResponse,
            'response_type' => $this->response->type,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
