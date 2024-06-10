<?php

namespace App\Services;

use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as BarryPDF;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ContractPdfService implements ContractPdfInterface
{
    /**
     * @throws Exception
     */
    public function generateContractPdf(Event $event): string
    {
        $pdf = $this->createPdf($event);

        $pdfContent = $pdf->output();

        $filename = 'contracts/' . $this->generateContractFilename($event);

        $pdfSaved = Storage::put($filename, $pdfContent);

        if (!$pdfSaved) {
            throw new Exception(__('messages.pdf_save_error'));
        }

        return storage_path('app/' . $filename);
    }

    private function createPdf(Event $event, $showLinks = false): BarryPDF
    {
        return PDF::loadView('contracts.photo_booth_contract', ['event' => $event, 'showLinks' => $showLinks]);
    }

    public function generateContractFilename(Event $event): string
    {
        $clientName = $event->client->getFullName();
        $dateFormatted = $this->formatDateForFilename($event->getStartTime());

        return __('translations.contract_title') . "-" . $clientName . " " . $dateFormatted . ".pdf";
    }

    private function formatDateForFilename($date): string
    {
        return Carbon::parse($date)->format('d-m-Y');
    }

    public function deleteGeneratedPdf(string $pdfPath): void
    {
        Storage::delete($pdfPath);
    }

    public function generateContractPdfView(Event $event): BarryPDF
    {
        return $this->createPdf($event);
    }

    public function generateContractPdfInBrowser(Event $event): Response
    {
        $pdf = $this->createPdf($event);
        $filename = $this->generateContractFilename($event);

        return $pdf->stream($filename);
    }

    public function generateContractPdfToDownload(Event $event): Response
    {
        $pdf = $this->createPdf($event);
        $filename = $this->generateContractFilename($event);

        return $pdf->download($filename);
    }
}
