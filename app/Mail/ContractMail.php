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
    protected string $pdfOutput;

    protected ContractPdfService $contractPdfService;

    /**
     * Create a new message instance.
     */
    public function __construct(Event $event, string $pdfOutput)
    {
        $this->event = $event;
        $this->pdfOutput = $pdfOutput;
        $this->contractPdfService = new ContractPdfService();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'My Test Email',
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
        return [];
//        $filename = $this->contractPdfService->generateContractFilename($this->event);
//
//        $attachment = Attachment::fromData(fn() => $this->pdfOutput, $filename) ->withMime('application/pdf');
//
//        return [$attachment];
    }
}
