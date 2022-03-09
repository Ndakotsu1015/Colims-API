<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarEventStoreRequest;
use App\Http\Requests\CalendarEventUpdateRequest;
use App\Http\Resources\CalendarEventCollection;
use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
    	$data = $request->validated();
    	Log::debug("Calendar Event Post Data");
    	Log::debug($data);
    	$data["posted_by"] = auth()->user()->id;
        $calendarEvent = CalendarEvent::create($data);

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = 'New Calendar Event Posted';
        $notification->content = 'You just added a new calendar event entry for case with Case No.: ' . $calendarEvent->courtCase->case_no . ' on ' . now() . '.';
        $notification->save();

        $recipientEmail = auth()->user()->email;

        try {
            Mail::to($recipientEmail)->send(new \App\Mail\CalendarEvent ($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }

        $notification1 = new Notification();

        $notification1->user_id = $calendarEvent->courtCase->postedBy->id;
        $notification1->subject = 'New Calendar Event Posted';
        $notification1->content = 'Case Handler: ' . $calendarEvent->courtCase->handler->name . ' just added a new calendar event entry for Case with Case No.: ' .$calendarEvent->courtCase->case_no. 'on '.  now() . '.';
        $notification1->action_link = env('APP_URL') . '/#/litigations/calendar-events/' . $calendarEvent->id;
        $notification1->save();

        $recipientEmail1 = $calendarEvent->courtCase->postedBy->email;

        try {
            Mail::to($recipientEmail1)->send(new \App\Mail\CalendarEvent ($notification1));
        } catch (Exception $e) {
            Log::debug($e);
        }       

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
    	$data = $request->validated();
        $calendarEvent->update($data);

        return new CalendarEventResource($calendarEvent->load('postedBy', 'courtCase'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CalendarEvent $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CalendarEvent $calendarEvent)
    {
    	Log::debug("Deleting something...");
    	Log::debug($calendarEvent);
    	
        $calendarEvent->delete();

        return response()->noContent();
    }
}
