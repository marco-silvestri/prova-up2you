<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::get();
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'title' => 'required|bail|min:2|max:255',
                'description' => 'sometimes|min:5|max:1000',
                'scheduled_at' => [
                    'required',
                    'bail',
                    Rule::date()->format('Y-m-d H:i')
                ],
                'location' => 'required|min:5|max:255',
                'max_attendees' => 'required|numeric',
            ]);

            $event = Event::create($validated);
        }catch(Exception $e){
            return response()->json(
                ['msg' => 'Parameters not valid or event already registered'],
                 Response::HTTP_BAD_REQUEST
                );
        }

        return response()->json($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $event = Event::find($id);
        }catch(Exception $e){
            return response()->json(status: Response::HTTP_BAD_REQUEST);
        };

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validated = $request->validate([
                'title' => 'sometimes|min:2|max:255',
                'description' => 'sometimes|min:5|max:1000',
                'scheduled_at' => [
                    'sometimes',
                    'bail',
                    Rule::date()->format('Y-m-d H:i')
                ],
                'location' => 'sometimes|min:5|max:255',
                'max_attendees' => 'sometimes|numeric',
            ]);

            $event = Event::whereId($id)->update($validated);

        }catch(Exception $e){
            return response()->json(
                ['msg' => 'Parameters not valid'],
                 Response::HTTP_BAD_REQUEST
                );
        }

        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Event::find($id)->delete();
    }
}
