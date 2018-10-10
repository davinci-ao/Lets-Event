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
		$events = Event::where('status', 'accepted')->get();
		$user = auth()->user();
		return view('events', ['events' => $events, 'user' => $user]);
	}

	/**
	 *  loads in the view with the given objects
	 *  @return type view
	 */
	public function eventApprovalIndex()
	{

		$events = Event::where('status', 'tobechecked')->get();
		return view('eventsApproval', ['events' => $events]);
	}

	/**
	 *  @param type $eventID
	 *  Changes the event status to "accepted" where the $eventID  the same is in de database  when this function is called to.
	 *  @return back to blade with message
	 */
	public function eventApproval($eventID)
	{
		if (count(Event::where('id', $eventID)->get()) > 0) {

			$event = Event::where('id', $eventID)->first();
			$event->status = 'accepted';
			$event->save();

			Session::flash('positive', true);
			return back()->with('message', ' "' . $event->name . '" has been accepted and is added to the events list');
		} else {

			return back()->with('message', 'This event doesn\'t exist !');
		}
	}

	/**
	 *  @param type $eventID
	 *  Deletes the database entry where the $eventID  the same is in de database  when this function is called to.
	 *  @return back to blade with message
	 */
	public function eventDecline($eventID)
	{
		if (count(Event::where('id', $eventID)->get()) > 0) {

			$event = Event::where('id', $eventID)->first();
			$event->delete();

			Session::flash('positive', true);
			return back()->with('message', ' "' . $event->name . '" has been asuccesfully deleted');
		} else {

			return back()->with('message', 'This event doesn\'t exist !');
		}
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

					
					$userIds = participations::where('event_id', $event->id)->pluck('user_id');
					$guests = User::find($userIds);
					if (count($guests) == isset($event->maximum_members)){
						return $fail('no more free space');
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
		$user = auth()->user();
		$admin = User::where('role', 'teacher')->get();
		$location = locations::where('id', $event->location_id)->first();
		$userIds = participations::where('event_id', $eventID)->pluck('user_id');

		if ($userIds->isEmpty())
			$userIds = [0];
		$guests = User::find($userIds);

		
		return view('viewEvent', ['event' => $event, 'organizer' => $organizer,'user'=>$user, 'location' => $location, 'guests' => $guests]);
		if (empty($event->maximum_members)) {
			$event->maximum_members = '-';
		}



		return view('viewEvent', ['event' => $event, 'organizer' => $organizer, 'user' => $user, 'location' => $location, 'guests' => $guests, 'admin' => $admin]);
	}

	/**
	 * Edit event data
	 * @param type $eventId
	 */
	public function editEvent($id)
	{
		$event = Event::find($id);
		$locations = locations::all();

		if ($this->eventStatus === true) {
			$this->eventStatus = null;

			return view('eventEdit', ['event' => $event, 'locations' => $locations, 'status' => 'success', 'success' => $this->eventName]);
		}
		if ($this->eventStatus === false) {
			$this->eventStatus = null;
			return view('eventEdit', ['event' => $event, 'locations' => $locations, 'status' => 'fail']);
		}

        return view('eventEdit', ['event' => $event, 'locations' => $locations, 'status' => '', 'success' => $this->eventName]);
	}

	/**
     * Update event
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function editSaveEvent(Request $request)
    {

    	$eventData = $request->all();
    	$eventId = $eventData['id'];

		$validator = Validator::make($request->all(), [
			  'eventName' => 'required|max:40',
			  'eventDate' => 'required|date',
              'minimum_members' => 'nullable',
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
					$locations = locations::find($value);
					if (!isset($locations->id)) {
						return $fail('This location doesn\'t exist');
					}
				}],
			  'eventDescription' => 'nullable|max:255'
		]);

        if (!empty($eventData['maximum_members'])) {
            if ($eventData['minimum_members'] > $eventData['maximum_members']) {
                Session::flash('alert-danger', 'Minimum cannot be higher than maximum!');
                $this->eventStatus = false;
                return $this->editEvent($eventId);    
            }
        }

		if ($validator->fails()) {
			$this->eventStatus = false;
			return $this->editEvent($eventId);
		}

		$event = Event::find($eventId);

		if (empty($eventData['eventPrice']))
			$eventData['eventPrice'] = 0;	

		$result = $event->updateEventData($eventData);
		
		$this->eventStatus = $result;
		$this->eventName = $eventData['eventName'];
		return $this->editEvent($eventId);
    	
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
		Session::flash('message', ' "' . $event->name . '" has been deleted succesfully');
		Session::flash('positive', true);

		return redirect('event/overview');
	}

}
