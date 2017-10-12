<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest');
	}

    function home(){
    	return view('home');
    }
	function play(){
		return view('game');
	}
	function rules(){
		return view('rules');
	}

	function add_player(){
		// add player info to IP
	}
}
