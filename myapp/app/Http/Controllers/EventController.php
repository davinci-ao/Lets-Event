<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Event;
use App\Http\Models\locations;
use App\Http\Models\participations;
use Auth;
use App\Http\Models\User;
use Validator;
use Session;

class EventController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	private $eventStatus;
	private $eventName;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = DB::table('events')->get();
        return view('events', ['events' => $events]);
    }


    public function registerEventAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 
                ['required',
                function($attribute, $value, $fail) {
                    $event = new event();
                    $event = $event::find($value);

                    if ( ! isset( $event->id ) ) {
                        return $fail('Event not found');
                    }   

                    $userEventLink = participations::where('user_id', Auth::user()->id )->where('event_id', $event->id)->first();
                    
                    if ( $userEventLink !== null ) {
                        return $fail('You are already registered for this event');
                    }                 
                }],
        ]);

        if ($validator->fails()) {
            return back()->with('message', implode("<br>", $validator->errors()->all() ) );      
        }


        $event = new event();
        $event = $event::find($request->input('id'));

        $registerUserToEvent = new participations();
        $registerUserToEvent->paid = false;
        $registerUserToEvent->event_id = $request->input('id');
        $registerUserToEvent->user_id = Auth::user()->id;
        $registerUserToEvent->result = '0';

        $registerUserToEvent->save();

        Session::flash('positive', true);


        return back()->with('message', 'You have succesvolley registered for the event "'.$event->name.'"' );

    }

    public function writeOutOfEvent(Request $request)
    {
        $writeOut = participations::where('user_id', Auth::user()->id )->where('event_id', $request->input('id'))->first();

        if ( ! isset($writeOut->user_id) ) return back()->with('message', 'You are not written in for this event');

        $writeOut->delete();

        Session::flash('positive', true);

        return back()->with('message', 'You have succesvolley written out for the event');
    }


	public function create()
	{
		$locations = new locations();
		$locations = $locations::all();

		if ($this->eventStatus === true) {
			$this->eventStatus = null;

			return view('event', ['locations' => $locations, 'status' => 'success', 'success' => $this->eventName]);
		}
		if ($this->eventStatus === false) {
			$this->eventStatus = null;
			return view('event', ['locations' => $locations, 'status' => 'fail']);
		}
		return view('event', ['locations' => $locations, 'status' => '', 'success' => $this->eventName]);
	}

	public function createSave(Request $request)
	{
		$eventData = $_POST;
		$validator = Validator::make($request->all(), [
			  'eventName' => 'required|max:40',
			  'eventDate' => 'required|date',
			  'eventTime' => ['required',
				function($attribute, $value, $fail) {
					$time = \DateTime::createFromFormat('G:i', $value);
					if ($time == false) {
						return $fail("Your time is invalid.");
					}
				}],
			  'eventPrice' => 'nullable|regex:/^[0-9]*\.?[0-9]{1,2}+$/',
			  'eventLocation' => ['required',
				'numeric',
				function($attribute, $value, $fail) {
					$locations = new locations();
					$locations = $locations::find($value);
					if (!isset($locations->id)) {
						return $fail('This location doesn\'t exist');
					}
				}],
			  'eventDescription' => 'nullable|max:255'
		]);

		if ($validator->fails()) {
			$this->eventStatus = false;
			return $this->create();
		}

		$event = new Event();
		if (empty($eventData['eventPrice']))
			$eventData['eventPrice'] = 0;
            $eventData['eventTime'] .= ':00';
		$result = $event->saveEventData($eventData);

		$this->eventStatus = $result;
		$this->eventName = $eventData['eventName'];
		return $this->create();
	}

	/**
	 * shows the event with the given id from the database
	 * @param type $eventID
	 */
	public function viewEvent($eventID)
	{

		$event = Event::where('id', $eventID)->first();
		$organizer = User::where('id', $event->user_id)->first();
		$location = locations::where('id', $event->location_id)->first();
        $userIds = participations::where('event_id', $eventID)->pluck('user_id');

        if ( $userIds->isEmpty() ) $userIds = [0];
        $guests = User::find([ $userIds ]);
    	
		return view('viewEvent', ['event' => $event, 'organizer' => $organizer, 'location' => $location, 'guests' => $guests]);

	}

	/**
	 * 
	 */
	public function editEvent()
	{
		
	}

	/**
	 * 
	 */
	public function deleteEvent()
	{
		
	}

}
