<?php

namespace App\Http\Models;

/**
 * Description of Event this is the model for the events
 *
 * @author Ian Storm
 */
class Event extends \Illuminate\Database\Eloquent\Model
{

	public $table = "events";
	protected $fillable = ['name', 'category_id', 'datum', 'time', 'price', 'minimum_members', 'maximum_members', 'location_id', 'description', 'user_id'];

	/**
	 * Saves the event name to the database with the data from eventData array
	 * @param type $eventData
	 * @return type array
	 */
	public function saveEventData($eventData)
	{
		$this->create([
		    "category_id" => 0,
		    "name" => $eventData['eventName'],
		    "datum" => $eventData['eventDate'],
		    "time" => $eventData['eventTime'],
		    "price" => $eventData['eventPrice'],
		    "minimum_members" => $eventData['minimum_members'],
            "maximum_members" => $eventData['maximum_members'],
		    "location_id" => $eventData['eventLocation'],
		    "description" => $eventData['eventDescription'],
		    "user_id" => auth()->user()->id
		]);

		return true;
	}

	public function hasEvent($eventObject)
	{
		if ($this->where("id", "=", $eventObject['id'])->count() > 0) {
			return true;
		}else{
			return false;
		}
	}

}
