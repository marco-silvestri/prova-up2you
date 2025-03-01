<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttendeeSubscribedToEvent;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class SubscribeAttendeeToEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try{
            $validated = $request->validate([
                'attendee_id' => 'required|numeric',
                'event_id' => 'required|numeric',
            ]);

            $event = Event::find($validated['event_id']);

            $currentParticipants = $event
                ->withCount('attendees')
                ->first();

            abort_if(
                $currentParticipants->attendees_count >= $event->max_attendees,
                Response::HTTP_BAD_REQUEST,
                'Max attendees limit reached'
            );

            $attendee = Attendee::find($validated['attendee_id']);

            $alreadySubscribed = $attendee
                ->events()
                ->where('event_id', $validated['event_id'])->exists();

            abort_if(
                $alreadySubscribed,
                Response::HTTP_BAD_REQUEST,
                'Attendee already subscribed'
            );

            $event->attendees()
                ->attach($validated['attendee_id']);

            Mail::to($attendee->email)
                ->send(new AttendeeSubscribedToEvent($event, $attendee));

            return response(status: Response::HTTP_NO_CONTENT);
        }catch(Exception $e)
        {
            return response(status: Response::HTTP_BAD_REQUEST);
        }
    }
}
