<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Event;
use App\Http\Models\locations;

use Validator;

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
}
