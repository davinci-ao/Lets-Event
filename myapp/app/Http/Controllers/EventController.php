<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Models\Category;
use App\Http\Models\Event;
use App\Http\Models\locations;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Session;
use Validator;
use Auth;

class EventController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('checkStatus');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('event.index', ['events' => Event::where('status', 'accepted')->orderBy('date_time')->get(), 'user' => auth()->user()]);
	}

	/**
	 * Display events that need approval
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function approve()
	{
		return view('event.approve', ['events' => Event::where('status', 'tobechecked')->get()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('event.create', ['locations' => locations::all(), 'categories' => Category::all()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$data = $this->toDefault($request->all());
		$validator = $this->validateEvent($data);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

		$data['eventPicture'] = "";
		$data['eventThumbnail'] = "";

		// picture for index page
		if ($request->file('eventThumbnail') != null) {
			$thumbnailName = Storage::put('public/EventThumbnails', $request->file('eventThumbnail'));
			$data['eventThumbnail'] = str_replace("public", "storage", $thumbnailName);
		}
		
		// picture for show page
		if ($request->file('eventPicture') != null) {
			$pictureName = Storage::put('public/EventPictures', $request->file('eventPicture'));
			$data['eventPicture'] = str_replace("public", "storage", $pictureName);
		}

		$event = new Event();
		$event = $event->saveEventData($data);

		if (!empty($request->tags)) {
			$tags = $this->saveTags($request->tags);
			$event->categories()->sync($tags);
		}

		return redirect()->route('event.create')->with('message', 'The event "' . $event->name . '" has been created.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$event = Event::where('id', $id)->first();

		if ($event === null) {
			return redirect()->route('event.index');
		}

		$organizer = User::where('id', $event->user_id)->first();
		$categories = $event->categories()->where('event_id', $id)->get();
		$location = locations::where('id', $event->location_id)->first();
		$guests = $event->users()->where('event_id', $id)->get();

		return view('event.show', ['event' => $event, 'organizer' => $organizer, 'location' => $location, 'guests' => $guests, 'categories' => $categories]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$event = Event::where('id', $id)->first();

		if ($event->user_id == Auth::user()->id || Auth::user()->role === 'teacher') {
			$eventCategory = $event->categories->pluck('id');

			return view('event.edit', ['event' => $event, 'locations' => locations::all(), 'categories' => Category::all(), 'eventTags' => $eventCategory]);
		}

		return back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$attend = isset($_GET['attend']) ? $_GET['attend'] : null;
		$approve = isset($_GET['approve']) ? $_GET['approve'] : null;
		$event = Event::find($id);

		if ($attend == null && $approve == null) {

			if ($event->user_id !== auth()->user()->id && auth()->user()->role !== 'teacher') {
				return redirect('event')->withErrors(['doesNotBelong' => 'This event does not belong to you']);
			}

			$data = $this->toDefault($request->all());
			$validator = $this->validateEvent($data);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			if (!empty($request->tags)) {
				$tags = $this->saveTags($request->tags);
				$event->categories()->sync($tags);
			}


			$data['eventPicture'] = $event->viewpicture;
			$data['eventThumbnail'] = $event->indexpicture;

			// picture for index page
			if ($request->file('eventThumbnail') != null || "") {
				$thumbnailName = Storage::put('public/EventThumbnails', $request->file('eventThumbnail'));
				$data['eventThumbnail'] = str_replace("public", "storage", $thumbnailName);
			}

			// picture for show page
			if ($request->file('eventPicture') != null || "") {
				$pictureName = Storage::put('public/EventPictures', $request->file('eventPicture'));
				$data['eventPicture'] = str_replace("public", "storage", $pictureName);
			}

			$event->updateEventData($data);
			$message = 'The event "' . $event->name . '" has been updated.';
		} else {
			if ($attend == 'in') {
				$event->users()->attach(Auth::user()->id, ['paid' => '0', 'result' => '0']);
				$message = 'You have succesfully been registered for the event "' . $event->name . '"';
			} else if ($attend == 'out') {
				$event->users()->detach(Auth::user()->id);
				$message = 'You have succesfully been unregistered for the event"' . $event->name . '"';
			} else if ($approve == 'accept' && Auth::user()->role === 'teacher') {
				$event->status = 'accepted';
				$event->save();
				return redirect()->route('eventApprove');
			}
		}

		return redirect()->route('event.show', ['id' => $id])->with('message', $message);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$event = Event::findOrFail($id);

		if (Auth::user()->role != "teacher") {
			if ($event->user_id != Auth::user()->id) {

				Session::flash('alert-class', 'alert-danger');
				return redirect('event.index')->with('message', 'You cant delete "' . $event->name . '" You are not the owner');
			}
		}

		$event->users()->detach();
		$event->categories()->detach();

		$event->delete();

		return redirect()->route('event.index')->with('message', ' "' . $event->name . '" has been deleted succesfully');
	}

	/**
	 * The event validation
	 *
	 * @param array to validate $validate
	 * @return errors $errors
	 */
	private function validateEvent($validate)
	{
		return $validator = Validator::make($validate, [
			  'eventName' => 'required|max:40',
			  'eventThumbnail' => 'image|dimensions:max_width=3840,max_height=2160|nullable|mimes:jpg,jpeg',
			  'eventPicture' => 'image|dimensions:max_width=2160,max_height=2160|nullable|mimes:jpg,jpeg',
			  'minimum_members' => 'nullable|min:0',
			  'maximum_members' => 'nullable|min:1|less_than_equal:' . $validate['minimum_members'],
			  'eventPrice' => 'required|regex:/^[0-9]*\.?[0-9]{1,2}+$/',
			  'eventLocation' => 'required|numeric|exists:locations,id',
			  'eventDescription' => 'nullable|max:255',
			  'shortdesc' => 'nullable|max:50',
			  'tags.*' => 'nullable|max:40', //validates the array, each item in array is max 40
			  'dateTime' => 'required|is_later_than_today'
		]);
	}

	/**
	 * Sets the NULL values to a default value
	 *
	 * @param param $param
	 * @return values $value
	 */
	private function toDefault($data)
	{
		if (empty($data['eventPrice']))
			$data['eventPrice'] = 0;

		if (!empty($data['eventDate']) || !empty($data['eventTime'])) {
			$data['dateTime'] = strtotime($data['eventDate'] . ' ' . $data['eventTime']);
		} else {
			$data['dateTime'] = false;
		}

		return $data;
	}

	/**
	 * Save the tags to the database
	 *
	 * @param tags $tags
	 * @return category_id tags $tags
	 */
	private function saveTags($tags)
	{
		foreach ($tags as $key => $value) {
			if (is_numeric($value)) {
				continue;
			}
			$tags[$key] = ucfirst(strtolower($tags[$key]));
			$category = new Category();
			$cat = $category->where('name', $tags[$key])->get();
			if ($cat->isNotEmpty()) {
				$tags[$key] = $cat[0]->id;
				continue;
			}
			$category = $category->createCategory($tags[$key]);

			$tags[$key] = $category->id;
		}
		return $tags;
	}

}
