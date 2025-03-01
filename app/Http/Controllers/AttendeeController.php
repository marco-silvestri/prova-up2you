<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendees = Attendee::get();
        return response()->json($attendees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'firstname' => 'required|bail|min:2|max:255',
                'lastname' => 'required|bail|min:2|max:255',
                'email' => 'required|email:strict|unique:attendees',
            ]);

            $attendee = Attendee::create($validated);
        }catch(Exception $e){
            return response()->json(
                ['msg' => 'Parameters not valid or attendee already registered'],
                 Response::HTTP_BAD_REQUEST
                );
        }

        return response()->json($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $attendee = Attendee::find($id);
        }catch(Exception $e){
            return response()->json(status: Response::HTTP_BAD_REQUEST);
        };

        return response()->json($attendee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validated = $request->validate([
                'firstname' => 'sometimes|min:2|max:255',
                'lastname' => 'sometimes|min:2|max:255',
                'email' => 'sometimes|email:strict|unique:attendees',
            ]);

            $attendee = Attendee::find($id)->update($validated);

        }catch(Exception $e){
            return response()->json(
                ['msg' => 'Parameters not valid'],
                 Response::HTTP_BAD_REQUEST
                );
        }

        return response()->json($attendee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Attendee::find($id)->delete();
    }
}
