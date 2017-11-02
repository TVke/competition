<?php

namespace App\Http\Controllers;

use App\Period;
use App\Player;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    function index(){
    	$players = Player::qualified()->latest()->paginate(30);
	    $periods = Period::limit(4)->get();
	    return view('settings',compact(['players','periods']));
    }

    function periods(Request $request){
	    $request->validate([
		    'start-1' => 'required|date',
		    'end-1' => 'required|date',

		    'start-2' => 'required|date',
		    'end-2' => 'required|date',

		    'start-3' => 'required|date',
		    'end-3' => 'required|date',

		    'start-4' => 'required|date',
		    'end-4' => 'required|date',
	    ]);
    	return "update periodes";
    }
}
