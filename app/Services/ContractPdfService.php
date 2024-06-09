<?php

namespace App\Services;

use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as BarryPDF;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class ContractPdfService implements ContractPdfInterface
{
    public function generateContractPdf(Event $event): string
    {
        $pdf = $this->createPdf($event);

        return $pdf->output();
    }

    private function createPdf(Event $event, $showLinks = false): BarryPDF
    {
        return PDF::loadView('contracts.photo_booth_contract', ['event' => $event, 'showLinks' => $showLinks]);
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

    public function generateContractFilename(Event $event): string
    {
        $eventName = $event->getEventName();
        $dateFormatted = $this->formatDateForFilename($event->getStartTime());

        return $eventName . " " . $dateFormatted . ".pdf";
    }

    private function formatDateForFilename($date): string
    {
        return Carbon::parse($date)->format('d-m-Y');
    }

    public function generateContractPdfToDownload(Event $event): Response
    {
        $pdf = $this->createPdf($event);
        $filename = $this->generateContractFilename($event);

        return $pdf->download($filename);
    }
}
