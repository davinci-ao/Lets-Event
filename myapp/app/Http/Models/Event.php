<?php

/**
 * Description of Event this is the model for the events
 *
 * @author team Yugioh
 */

namespace App\Http\Models;

class Event extends \Illuminate\Database\Eloquent\Model
{

	public $table = "events";

	public function location()
	{
		return $this->belongsTo('App\Http\Models\locations');
	}

	public function categories()
	{
		return $this->belongsToMany('App\Http\Models\Category');
	}

	public function users()
	{
		return $this->belongsToMany('App\Http\Models\User', 'participations');
	}

	protected $fillable = ['name', 'indexpicture', 'viewpicture', 'price', 'minimum_members', 'maximum_members', 'location_id', 'status', 'description', 'shortdescription', 'user_id', 'date_time'];

	/**
	 * Saves the event name to the database with the data from eventData array
	 * @param type $eventData
	 * @return type array
	 */
	public function saveEventData($eventData)
	{
		if (auth()->user()->role == "teacher" || auth()->user()->role == "organisator") {
			$status = "accepted";
		} else {
			$status = "tobechecked";
		}

		return $this->create([
			  "status" => $status,
			  "name" => $eventData['eventName'],
			  "indexpicture" => $eventData['eventThumbnail'],
			  "viewpicture" => $eventData['eventPicture'],
			  "date_time" => $eventData['dateTime'],
			  "price" => $eventData['eventPrice'],
			  "minimum_members" => $eventData['minimum_members'],
			  "maximum_members" => $eventData['maximum_members'],
			  "location_id" => $eventData['eventLocation'],
			  "description" => $eventData['eventDescription'],
			  "shortdescription" => $eventData['shortdesc'],
			  "user_id" => auth()->user()->id
		]);
	}

	/**
	 * Saves the event name to the database with the data from eventData array
	 * @param type $eventData
	 * @return type array
	 */
	public function updateEventData($eventData)
	{
		$this->fill([
		    "name" => $eventData['eventName'],
		    "indexpicture" => $eventData['eventThumbnail'],
		    "viewpicture" => $eventData['eventPicture'],
		    "date_time" => $eventData['dateTime'],
		    "price" => $eventData['eventPrice'],
		    "minimum_members" => $eventData['minimum_members'],
		    "maximum_members" => $eventData['maximum_members'],
		    "location_id" => $eventData['eventLocation'],
		    "description" => $eventData['eventDescription'],
		    "shortdescription" => $eventData['shortdesc']
		]);
		return $this->save();
	}

	public function hasEvent($eventObject)
	{
		if ($this->where("id", "=", $eventObject['id'])->count() > 0) {
			return true;
		} else {
			return false;
		}
	}

}
