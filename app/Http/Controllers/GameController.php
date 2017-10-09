<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    function home(){
    	return view('home');
    }
	function play(){
		return view('game');
	}
}
