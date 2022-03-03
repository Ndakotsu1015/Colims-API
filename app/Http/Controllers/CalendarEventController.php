<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarEventStoreRequest;
use App\Http\Requests\CalendarEventUpdateRequest;
use App\Http\Resources\CalendarEventCollection;
use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use App\Models\Notification;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CalendarEventCollection
     */
    public function index(Request $request)
    {
        $calendarEvents = CalendarEvent::with('postedBy', 'courtCase')->latest()->get();

        return new CalendarEventCollection($calendarEvents);
    }

    /**
     * @param \App\Http\Requests\CalendarEventStoreRequest $request
     * @return \App\Http\Resources\CalendarEventResource
     */
    public function store(CalendarEventStoreRequest $request)
    {
        $calendarEvent = CalendarEvent::create($request->validated());

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = 'New Calendar Event Posted';
        $notification->content = 'You just added a new calendar event entry for case with Case No.: ' . $calendarEvent->courtCase->case_no . ' on ' . now() . '.';
        $notification->save();

        $recipientEmail = auth()->user()->email;
        
        Mail::to($recipientEmail)->send(new \App\Mail\CalendarEvent ($notification));

        $notification1 = new Notification();

        $notification1->user_id = $calendarEvent->courtCase->postedBy->id;
        $notification1->subject = 'New Calendar Event Posted';
        $notification1->content = 'Case Handler: ' . $calendarEvent->courtCase->handler->name . ' just added a new calendar event entry for Case with Case No.: ' .$calendarEvent->courtCase->case_no. 'on '.  now() . '.';
        $notification1->action_link = env('APP_URL') . '/calendar-events/' . $calendarEvent->id;
        $notification1->save();

        $recipientEmail1 = $calendarEvent->courtCase->postedBy->email;
        Mail::to($recipientEmail1)->send(new \App\Mail\CalendarEvent ($notification1));

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
