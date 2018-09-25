<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Event;
use App\Http\Models\locations;
use App\Http\Models\linked_user_event;

use Auth;
use Validator;
use Session;

class EventController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    // show all events
    public function index()
    {
/*
        $events = Event::all();
        return view('events')->with(['events' => $events]);
*/
    	$events = DB::table('events')->get();
        return view('events', ['events' => $events]);
         /* parent of 8107349... overzicht van events kunnen worden opgevraagd*/
    }

    public function registerEvent($id)
    {
        $event = Event::find($id);

        if ( !isset($event->id) ) return redirect()->route('eventIndex')->with('message', 'event not found');

        $registerUserToEvent = new linked_user_event();
        $registerUserToEvent = $registerUserToEvent::where('user_id', Auth::user()->id )->where('event_id', $id)->first();

        if ( isset($registerUserToEvent->event_id) )  return redirect()->route('eventIndex')->with('message', 'You have already signed up for this event');

        return view('RegisterEvent', ['event' => $event]);
    }

    public function registerEventAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 
                ['required',
                function($attribute, $value, $fail) {
                    $event = new event();
                    $event = $event::find($value);

                    if ( !isset($event->id) ) {
                        return $fail('Event not found');
                    }                    
                }],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);      
        }

        $event = new event();
        $event = $event::find( $request->input('id') );

        $registerUserToEvent = new linked_user_event();
        $registerUserToEvent->paid = false;
        $registerUserToEvent->event_id = $request->input('id');
        $registerUserToEvent->user_id = Auth::user()->id;

        $registerUserToEvent->save();

        Session::flash('positive', true);

        return redirect()->route('eventIndex')->with('message', 'You have succesvolley registered for the event "'.$event->name.'"' );
    }
}
