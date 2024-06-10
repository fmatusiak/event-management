<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Services\EmailService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailController extends Controller
{
    protected EmailService $emailService;
    protected EventRepository $eventRepository;

    public function __construct(EmailService $emailService, EventRepository $eventRepository)
    {
        $this->emailService = $emailService;
        $this->eventRepository = $eventRepository;
    }

    public function sendContractEmail(Request $request, int $eventId): RedirectResponse
    {
        try {
            $event = $this->eventRepository->get($eventId);
            $this->emailService->sendContractEmail($event);

            return back()->with('status', __('messages.success_contract_sent'));
        } catch (Exception $e) {
            return back()->with('error', __('messages.error_sending_contract' . $e->getMessage()));
        }
    }

    public function previewContractEmail(int $eventId): View
    {
        try {
            $event = $this->eventRepository->get($eventId);

            return view('emails.contract', ['event' => $event]);
        } catch (Exception $e) {
            return view('emails.contract', ['error' => $e->getMessage()]);
        }
    }
}
