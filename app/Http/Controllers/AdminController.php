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
		    'friend_email' => 'required|email|unique:players|unique:players,email|min:5|max:255',
	    ]);
    	return "update periodes";
    }
}
