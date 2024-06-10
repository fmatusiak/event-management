<?php

namespace App\Mail;

use App\Models\Event;
use App\Services\ContractPdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractMail extends Mailable
{
    use Queueable, SerializesModels;

    protected Event $event;
    protected string $pdfPath;

    protected ContractPdfService $contractPdfService;

    /**
     * Create a new message instance.
     */
    public function __construct(Event $event, string $pdfPath)
    {
        $this->event = $event;
        $this->pdfPath = $pdfPath;
        $this->contractPdfService = app(ContractPdfService::class);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('translations.contract_title'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contract',
            with: ['event' => $this->event]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachment = Attachment::fromPath($this->pdfPath)->withMime('application/pdf');

        return [$attachment];
    }
}
