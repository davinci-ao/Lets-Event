<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

/**
 * Description of EventsController
 *
 * @author Ian Storm
 */
class EventsController extends Controller
{
	
	private $eventStatus;
	
	/**
	 * Loads the web page with the corresponding parameter value supplied from $parra
	 * @param type $parra
	 * @return type view
	 */
	public function index()
	{
			if ($this->eventStatus === true) {
				$this->eventStatus = null;
				return view('event', ['status' => 'success']);
			}
			return view('event', ['status' => '']);
		}
	

	/**
	 *  Gives the event model the data from the form POST
	 */
	public function createEvent()
	{	
		$eventData = $_POST;
		//dd($eventData);
		$event = new Event();
		$result = $event->saveEventData($eventData);
		
		$this->eventStatus = $result;
		return $this->index("create");
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
