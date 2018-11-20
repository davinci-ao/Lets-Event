<?php

namespace App\Http\Controllers;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::where('status', 'accepted')->get();
        $user = auth()->user();
        return view('event.eventIndex', ['events' => $events, 'user' => $user]);
    }

    /**
     * Display events that need approval
     *
     * @return \Illuminate\Http\Response
     */
    public function approveIndex()
    {
        $events = Event::where('status', 'tobechecked')->get();
        return view('event.eventApproval', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = locations::all();
        $categories = Category::all();
        return view('event.eventCreate', ['locations' => $locations, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateEvent($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $eventData = $this->toDefault($request->all());
        $event = new Event();
        $event = $event->saveEventData($eventData);
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

        return view('event.eventView', ['event' => $event, 'organizer' => $organizer, 'location' => $location, 'guests' => $guests, 'categories' => $categories]);
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

            return view('event.eventEdit', ['event' => $event, 'locations' => locations::all(), 'categories' => Category::all(), 'eventTags' => $eventCategory]);
        }
        return redirect('event');
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

            $validator = $this->validateEvent($request->all());

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (!empty($request->tags)) {
                $tags = $this->saveTags($request->tags);
                $event->categories()->sync($tags);
            }
            $event->updateEventData($request->all());
            $message = 'The event "' . $event->name . '" has been updated.';
        } else {
            if ($attend == 'in') {
                $event->users()->attach(Auth::user()->id, ['paid' => '0', 'result' => '0']);
                $message = 'You have succesfully been registered for the event "' . $event->name . '"';
            } else if ($attend == 'out') {
                $event->users()->detach(Auth::user()->id);
                $message = 'You have succesfully been unregistered for the event"' . $event->name . '"';
            } else if ($approve == 'accept') {
                $event->status = 'accepted';
                $event->save();
                return redirect('event');
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
        
        $event = Event::where('id', $id)->first();
        
        if (Auth::user()->role != "teacher") {
            if ($event->user_id != Auth::user()->id) {

                Session::flash('alert-class', 'alert-danger');
                return redirect('event.index')->with('message', 'You cant delete "' . $event->name . '" You are not the owner');
            }
        }

        $event->users()->detach();
        $event->categories()->detach();

        Event::where('id', $id)->delete();

        return redirect()->route('event.index')->with('message', ' "' . $event->name . '" has been deleted succesfully');
    }

    /**
     *The event validation
     *
     *@param array to validate $validate
     *@return errors $errors
     */
    private function validateEvent($validate)
    {
        return $validator = Validator::make($validate, [
            'eventName' => 'required|max:40',
            'eventDate' => 'required|date',
            'minimum_members' => 'nullable|min:0',
            'maximum_members' => 'nullable|min:1|less_than_equal:' . $validate['minimum_members'],
            'eventTime' => ['required',
                function ($attribute, $value, $fail) {
                    $time = \DateTime::createFromFormat('G:i', $value);
                    if ($time == false) {
                        return $fail("Your time is invalid.");
                    }
                }],
            'eventPrice' => 'nullable|regex:/^[0-9]*\.?[0-9]{1,2}+$/',
            'eventLocation' => ['required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $locations = new locations();
                    $locations = $locations::find($value);
                    if (!isset($locations->id)) {
                        return $fail('This location doesn\'t exist');
                    }
                }],
            'eventDescription' => 'nullable|max:255',
            'tags.*' => 'nullable|max:40', //validates the array, each item in array is max 40
        ]);
    }

    /**
     * Sets the NULL values to a default value
     *
     *@param param $param
     *@return values $value
     */

    private function toDefault($data)
    {
        if (empty($data['eventPrice'])) {
            $data['eventPrice'] = 0;
        }
        //$data['eventTime'] .= ':00';
        return $data;
    }

    /**
     * Save the tags to the database
     *
     *@param tags $tags
     *@return category_id tags $tags
     */
    private function saveTags($tags) {
        foreach ($tags as $key => $value) {
            if (is_numeric($value)) {
                continue;
            }
            $tags[$key] = ucfirst(strtolower($tags[$key]));
            $category = new Category();
            $cat = $category->where('name', $tags[$key])->get();
            if ($cat->isNotEmpty()) {
                continue;
            }
            $category = $category->createCategory($tags[$key]);

            $tags[$key] = $category->id;
        }
        return $tags;
    }
}
