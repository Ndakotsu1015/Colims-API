<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarEventStoreRequest;
use App\Http\Requests\CalendarEventUpdateRequest;
use App\Http\Resources\CalendarEventCollection;
use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CalendarEventCollection
     */
    public function index(Request $request)
    {
        $calendarEvents = CalendarEvent::with('postedBy', 'courtCase')->get();

        return new CalendarEventCollection($calendarEvents);
    }

    /**
     * @param \App\Http\Requests\CalendarEventStoreRequest $request
     * @return \App\Http\Resources\CalendarEventResource
     */
    public function store(CalendarEventStoreRequest $request)
    {
        $calendarEvent = CalendarEvent::create($request->validated());

        return new CalendarEventResource($calendarEvent->load('postedBy', 'courtCase'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CalendarEvent $calendarEvent
     * @return \App\Http\Resources\CalendarEventResource
     */
    public function show(Request $request, CalendarEvent $calendarEvent)
    {
        return new CalendarEventResource($calendarEvent->load('postedBy', 'courtCase'));
    }

    /**
     * @param \App\Http\Requests\CalendarEventUpdateRequest $request
     * @param \App\Models\CalendarEvent $calendarEvent
     * @return \App\Http\Resources\CalendarEventResource
     */
    public function update(CalendarEventUpdateRequest $request, CalendarEvent $calendarEvent)
    {
        $calendarEvent->update($request->validated());

        return new CalendarEventResource($calendarEvent->load('postedBy', 'courtCase'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CalendarEvent $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CalendarEvent $calendarEvent)
    {
        $calendarEvent->delete();

        return response()->noContent();
    }
}
