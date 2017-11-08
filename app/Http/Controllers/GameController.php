<?php

namespace App\Http\Controllers;

use App\Period;
use App\Player;
use Illuminate\Support\Facades\Cookie;

class GameController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest');
	}

    function home(){
	    $winners = Period::whereNotNull('winner')->with('winners')->orderBy('id')->get();
	    $end_date = Period::currentPeriode()->end;
    	return view('home',compact(['winners','end_date']));
    }
	function play(){
    	$ip = request()->getClientIp();
		$cookie = false;
		if(Cookie::get('game_player')){ // checks if cookie is set
			if(Player::where('safety_token',Cookie::get('game_player'))->count() > 0){ // checks if player from cookie exists

				$cookie = Player::where('safety_token',Cookie::get('game_player'))->first();

				if($cookie->mail_opened === 1 && (Player::where('email',$cookie->friend_email)->count() > 0)){
					session()->put(['newChange'=>'newChange']);
				}
			}
		}
		return view('game',compact(['ip','cookie']));
	}
	function rules(){
		$periodes = Period::all();
		return view('rules', compact('periodes'));
	}
}
