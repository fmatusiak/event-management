<?php

namespace App\Http\Controllers;

use App\Exceptions\EventsOverlapException;
use App\Models\Package;
use App\Repositories\EventRepository;
use App\Services\EventService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    protected EventService $eventService;
    protected EventRepository $eventRepository;

    public function __construct(EventService $eventService, EventRepository $eventRepository)
    {
        $this->eventService = $eventService;
        $this->eventRepository = $eventRepository;
    }

    public function paginate(Request $request): View
    {
        try {
            $filters = $request->input('filters', []);
            $columns = $request->input('columns', ['*']);
            $perPage = $request->input('per_page', 15);

            $paginator = $this->eventRepository->paginate($filters, $perPage, $columns);

            return view('events.index', ['paginator' => $paginator]);
        } catch (Exception) {
            return view('events.index', ['error' => __('messages.error_pagination')]);
        }
    }

    public function storeEvent(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $event = $this->eventService->createEvent($request->all());

            return redirect()->route('events.create')->with('status', __('messages.created') . " " . $event->getEventName());
        } catch (EventsOverlapException) {
            return back()->withInput()->with('error', __('messages.events_overlap'));
        } catch (Exception $e) {
            return back()->withInput()->with('error', __('messages.error_create'));
        }
    }

    public function createEvent(): View
    {
        $packages = Package::all();

        return view('events.create',['packages' => $packages]);
    }

    public function updateEvent(int $eventId, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $this->eventService->updateEvent($eventId, $request->all());

            return redirect()->route('events.edit', ['eventId' => $eventId])->with('status', __('messages.updated'));
        } catch (ModelNotFoundException) {
            return back()->withInput()->with('error', __('messages.not_found'));
        } catch (EventsOverlapException) {
            return back()->withInput()->with('error', __('messages.events_overlap'));
        } catch (Exception) {
            return back()->withInput()->with('error', __('messages.error_update'));
        }
    }

    public function getEvent(int $eventId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $event = $this->eventRepository->get($eventId);

            return view('events.edit', ['event' => $event]);
        } catch (ModelNotFoundException) {
            return back()->with('error', __('messages.not_found'));
        } catch (Exception) {
            return back()->with('error', __('messages.error_retrieve'));
        }
    }

    public function deleteEvent(int $eventId): JsonResponse
    {
        try {
            $this->eventRepository->delete($eventId);

            return response()->json(['status' => __('messages.deleted')]);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => __('messages.not_found')]);
        } catch (Exception) {
            return response()->json(['error' => __('messages.error_delete')]);
        }
    }

}
