<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class InvoiceGenerated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Invoice $invoice
    ) {
        $this->onQueue('emails');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Invoice #' . $this->invoice->invoice_number,
            from: config('mail.from.address'),
            to: [$this->invoice->customer->email],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-generated',
            with: [
                'invoice' => $this->invoice,
                'customer' => $this->invoice->customer,
                'dueDate' => $this->invoice->due_date->format('F j, Y'),
                'totalAmount' => number_format($this->invoice->total_amount, 2),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Optionally attach PDF invoice
        return [
            // Attachment::fromPath(storage_path('app/invoices/' . $this->invoice->id . '.pdf'))
            //     ->as('invoice-' . $this->invoice->invoice_number . '.pdf')
            //     ->withMime('application/pdf'),
        ];
    }
}
