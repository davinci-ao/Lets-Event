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
	 * @return blade
	 */
	public function index()
	{
		$events = DB::table('events')->get();
		return view('events', ['events' => $events]);
	}

	/**
	 * Lets a user register for a event.
	 * @param Request $request
	 * @return type blade
	 */
	public function registerEventAction(Request $request)
	{
		$validator = Validator::make($request->all(), [
			  'id' =>
			  ['required',
				function($attribute, $value, $fail) {
					$event = new event();
					$event = $event::find($value);

					if (!isset($event->id)) {
						return $fail('Event not found');
					}

					$userEventLink = participations::where('user_id', Auth::user()->id)->where('event_id', $event->id)->first();


					if ($userEventLink !== null) {
						return $fail('You are already registered for this event');
					}
				}],
		]);

		if ($validator->fails()) {
			return back()->with('message', implode("<br>", $validator->errors()->all()));
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
		return back()->with('message', 'You have succesvolley registered for the event "' . $event->name . '"');
	}

	/**
	 * Lets the user leave the event he/she registered for.
	 * @param Request $request
	 * @return type blade
	 */
	public function writeOutOfEvent(Request $request)
	{
		$writeOut = participations::where('user_id', Auth::user()->id)->where('event_id', $request->input('id'))->first();

		if (!isset($writeOut->user_id))
			return back()->with('message', 'You are not written in for this event');

		$writeOut->delete();

		Session::flash('positive', true);

		return back()->with('message', 'You have succesvolley written out for the event');
	}

	/**
	 * shows the blade to make a event.
	 * @return type blade
	 */
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

	/**
	 * validates the data given from the event create form.
	 * @param Request $request
	 * @return type fail or succes
	 */
	public function createSave(Request $request)
	{
		$eventData = $_POST;
		$validator = Validator::make($request->all(), [
			  'eventName' => 'required|max:40',
			  'eventDate' => 'required|date',
              'minimum_members' => 'required',
              'maximum_members' => 'nullable',

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

        if (!empty($eventData['maximum_members'])) {
            if ($eventData['minimum_members'] > $eventData['maximum_members']) {
                Session::flash('alert-danger', 'Minimum cannot be higher than maximum!');
                $this->eventStatus = false;
                return $this->create();    
            }
        }


		$event = new Event();
		if (empty($eventData['eventPrice']))
			$eventData['eventPrice'] = 0;
		$eventData['eventTime'] .= ':00';
        if (empty($eventData['maximum_members'])) {
            $eventData['maximum_members'] = NULL;
        }

		$result = $event->saveEventData($eventData);

		$this->eventStatus = $result;
		$this->eventName = $eventData['eventName'];
		return $this->create();
	}

	/**
	 * shows the event data with the given id from the database
	 * @param type $eventID
	 */
	public function viewEvent($eventID)
	{

		$event = Event::where('id', $eventID)->first();
		$organizer = User::where('id', $event->user_id)->first();
		$user = auth()->user()->id;
		$location = locations::where('id', $event->location_id)->first();
		$userIds = participations::where('event_id', $eventID)->pluck('user_id');

		if ($userIds->isEmpty()) $userIds = [0];
		$guests = User::find($userIds);

		
		return view('viewEvent', ['event' => $event, 'organizer' => $organizer,'user'=>$user, 'location' => $location, 'guests' => $guests]);
	}

	/**
	 * 
	 */
	public function editEvent()
	{
		
	}

	/**
	 *  Deletes the event & users that registered to the event by given id from the database.
	 * @param Request $request
	 * @param type $eventId
	 * @return type blade
	 */
	public function deleteEvent(Request $request, $eventId)
	{
		$event = Event::where('id', $eventId)->first();
		if (!isset($event->id)) {

			Session::flash('message', 'Event does not exists');
			return redirect('event/overview');
		}
		if ($event->user_id != Auth::user()->id) {

			Session::flash('message', 'U cant delete "' . $event->name . '" You are not the owner');
			return redirect('event/overview');
		}

		participations::where('event_id', $eventId)->delete();

		Event::where('id', $eventId)->delete();
		Session::flash('message', ' U successfully deleted"' . $event->name . '" ');
        Session::flash('positive', true);

		return redirect('event/overview');
	}

}
