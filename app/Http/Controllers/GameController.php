<?php

namespace App\Http\Controllers;

use App\Period;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

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
		if(Cookie::get('game_player')){
			$cookie = Player::where('safety_token',Cookie::get('game_player'))->first();
		}
		return view('game',compact(['ip','cookie']));
	}
	function rules(){
		$periodes = Period::all();
		return view('rules', compact('periodes'));
	}


	function friend_invite(Request $request){
//		return $request;
		$request->validate([
			'friend_email' => 'required|email|unique:players|unique:players,email|min:5|max:255',
		]);

		if(Cookie::get('game_player')){
			$currentPlayer = Player::where('safety_token',Cookie::get('game_player'))->first();
			$token = Hash::make($currentPlayer->email.$request->friend_email);
			$currentPlayer->update([
				'friend_token' => $token,
				'friend_email' => $request->friend_email,
			]);
		}
		return "added friend";
	}

	function mail(){
		Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
		{
			$message->subject('Mailgun and Laravel are awesome!');
			$message->from('thomas.verhelst@studnet.kdg.be', 'Wedstrijd.local');
			$message->to('tvke91@gmail.com');
		});
	}
}
