<?php

namespace App;

/**
 * Description of Event this is the model for the events
 *
 * @author Ian Storm
 */
class Event extends \Illuminate\Database\Eloquent\Model
{

	public $table = "events";
	protected $fillable = ['name', 'category_id', 'datum', 'time', 'price', "location_id", "user_id"];

	/**
	 * Saves the event name to the database with the data from eventData array
	 * @param type $eventData
	 * @return type array
	 */
	public function saveEventData($eventData)
	{
		if ($this->where("name", "=", $eventData['eventName'])->count() > 0) {
			return false;
		}
		if (empty($eventData['eventName'])) {
			return false;
		}
		$this->create([
			"category_id" => 0,
		    "name" => $eventData['eventName'],
		    "datum" => $eventData['eventDate'],
		    "time" => $eventData['eventTime'],
		    "price" => $eventData['eventPrice'],
		    "location_id" => $eventData['eventLocation'],
		    "user_id" => auth()->user()->id
		]);
		
		return true;
	}

}