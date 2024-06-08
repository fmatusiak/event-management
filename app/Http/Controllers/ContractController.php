<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Services\ContractPdfService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\View\View;

class ContractController extends Controller
{
    protected EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function generateContractForEvent(int $eventId): View
    {
        try {
            $event = $this->eventRepository->get($eventId);

            return view('contracts.photo_booth_contract', ['event' => $event, 'showLinks' => true]);
        } catch (ModelNotFoundException $e) {
            return view('contracts.photo_booth_contract', ['error' => __('messages.not_found') . __('translations.events') . $e->getMessage()]);
        } catch (Exception $e) {
            return view('contracts.photo_booth_contract', ['error' => __('messages.error_generate_contract_for_event') . $e->getMessage()]);
        }
    }

    public function generateContractPdfInBrowser(int $eventId, ContractPdfService $contractPdfService)
    {
        try {
            $event = $this->eventRepository->get($eventId);

            return $contractPdfService->generateContractPdfInBrowser($event);
        } catch (ModelNotFoundException $e) {
            return view('contracts.preview', ['error' => __('messages.not_found') . $e->getMessage()]);
        } catch (Exception $e) {
            return view('contracts.preview', ['error' => __('messages.error_generate_contract_for_event') . $e->getMessage()]);
        }
    }

    public function generateContractPdfToDownload(int $eventId, ContractPdfService $contractPdfService)
    {
        try {
            $event = $this->eventRepository->get($eventId);

            return $contractPdfService->generateContractPdfToDownload($event);
        } catch (ModelNotFoundException $e) {
            return view('contracts.preview', ['error' => __('messages.not_found') . $e->getMessage()]);
        } catch (Exception $e) {
            return view('contracts.preview', ['error' => __('messages.error_generate_contract_for_event') . $e->getMessage()]);
        }
    }
}
