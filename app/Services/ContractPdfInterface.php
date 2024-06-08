<?php

namespace App\Services;

use App\Models\Event;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;

interface ContractPdfInterface
{
    public function generateContractPdf(Event $event): string;

    public function generateContractPdfView(Event $event): PDF;

    public function generateContractPdfInBrowser(Event $event): Response;

    public function generateContractPdfToDownload(Event $event): Response;

}
