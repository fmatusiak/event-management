<?php

namespace App\Services;

use App\Mail\ContractMail;
use App\Models\Email;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailService implements EmailServiceInterface
{
    private ContractPdfService $contractPdfService;

    public function __construct(ContractPdfService $contractPdfService)
    {
        $this->contractPdfService = $contractPdfService;
    }

    public function sendContractEmail(Event $event): void
    {
        try {
            DB::beginTransaction();

            $clientEmail = $event->client->getEmail();

            $pdfPath = $this->contractPdfService->generateContractPdf($event);

            $contractMail = new ContractMail($event, $pdfPath);

            $messageSent = Mail::to($clientEmail)->sendNow($contractMail);

            if (!$messageSent) {
                throw new Exception(__('messages.mail_send_failed'));
            }

            $emailContent = $contractMail->render();

            Email::create([
                'event_id' => $event->id,
                'to' => $clientEmail,
                'body' => $emailContent,
            ]);

            $this->contractPdfService->deleteGeneratedPdf($pdfPath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
