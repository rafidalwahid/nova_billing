<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Payment $payment
    ) {
        $this->onQueue('emails');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Confirmation - $' . number_format($this->payment->amount, 2),
            from: config('mail.from.address'),
            to: [$this->payment->customer->email],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-received',
            with: [
                'payment' => $this->payment,
                'customer' => $this->payment->customer,
                'invoice' => $this->payment->invoice,
                'paymentAmount' => number_format($this->payment->amount, 2),
                'paymentDate' => $this->payment->payment_date->format('F j, Y'),
                'paymentMethod' => ucwords(str_replace('_', ' ', $this->payment->payment_method)),
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
        return [];
    }
}
