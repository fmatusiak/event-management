<?php

namespace App\Services;

use App\Mail\ContractMail;
use App\Models\Event;
use App\Repositories\EmailRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use ReflectionException;

class EmailService implements EmailServiceInterface
{
    private ContractPdfService $contractPdfService;

    private EmailRepository $emailRepository;

    public function __construct(ContractPdfService $contractPdfService, EmailRepository $emailRepository)
    {
        $this->contractPdfService = $contractPdfService;
        $this->emailRepository = $emailRepository;
    }

    /**
     * @throws ReflectionException
     */
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

            $emailData = [
                'event_id' => $event->id,
                'to' => $clientEmail,
                'subject' => $contractMail->subject,
                'body' => $emailContent,
            ];

            $this->emailRepository->create($emailData);

            $this->contractPdfService->deleteGeneratedPdf($pdfPath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
