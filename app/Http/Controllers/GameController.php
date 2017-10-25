<?php

namespace App\Http\Controllers;

use App\Period;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GameController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest');
	}

    function home(){
	    $winners = Period::whereNotNull('winner')->with('winners')->orderBy('id')->get();
	    $current_periode = 1;
	    for($i=1,$ilen=count(Period::all());$i<=$ilen;++$i){
	    	$periode = Period::where('id',$i)->first();
		    if(Carbon::now()->between($periode->start,$periode->end)){
			    $current_periode = $periode->id;
			    break;
		    }
	    }
	    $end_date = Period::where('id',$current_periode)->first()->end;
    	return view('home',compact(['winners','end_date']));
    }
	function play(){
    	$ip = request()->getClientIp();
		return view('game',compact('ip'));
	}
	function rules(){
		$periodes = Period::all();
		return view('rules', compact('periodes'));
	}

	function start(Request $request){
		$currentTime = round(microtime(true),4);
		$encryptedToken = Hash::make($request->getClientIp().$request->input(['_token']));

		// adding new Player
		$player = new Player();
		$player->ip = $request->getClientIp();

		// checks of foul play
		if($request->ip !== $request->getClientIp() || !$request->is('start')){
			$player->possible_dis = 1;
		}

		$player->start = $currentTime;
		$player->safety_token = $encryptedToken;
		$player->save();
		return $encryptedToken;
	}
	function end(Request $request){
		$currentTime = round(microtime(true),4);
		$extraToken = $request->et;
		$newToken = Hash::make($request->input(['_token']).$request->getClientIp().$request->ti);

		// finding playing player
		if(Player::where([['safety_token',$extraToken],['surname',null]])->count() === 1){
			$currentPlayer = Player::where([['safety_token',$extraToken],['surname',null]])->first();
		}
		elseif(Player::where([['ip',$request->getClientIp()],['surname',null]])->count() === 1){
			$currentPlayer = Player::where([['ip',$request->getClientIp()],['surname',null]])->first();
		}
		else{
			$newPlayer = new Player();
			$newPlayer->ip = $request->getClientIp();
			$newPlayer->possible_dis = 1;
			$currentPlayer = $newPlayer->save();
		}

		// check foul play
		if($currentPlayer->possible_dis === 1 ||
			$currentPlayer->safety_token !== $extraToken ||
			!Hash::check($request->getClientIp().$request->input(['_token']), $extraToken) ||
			$request->ip !== $request->getClientIp())
		{
			$poss_dis = 1;
		}
		else{
			$poss_dis = 0;
		}

		// updating player's end time
		$currentPlayer->update([
			'end' => $currentTime,
			'time' => intval($request->ti),
			'safety_token' => $newToken,
			'possible_dis' => $poss_dis
		]);
		return $newToken;
	}

	function add_player(Request $request){
//		return $request;
		// check player info

		$request->validate([
//			'time' => 'required|integer',
			'first_name' => 'required|string|max:255',
			'surname' => 'required|string|max:255',
			'email' => 'required|email|max:255',
			'adres' => 'required|string|max:255',
			'postalcode' => 'required|alpha_num|max:10',
			'city' => 'required|string|max:255',
		]);
		$extraToken = $request->et;

		//player exists
		if(Player::where([['safety_token',$extraToken],['surname',null]])->count() === 1){
			$currentPlayer = Player::where([['safety_token',$extraToken],['surname',null]])->first();
		}
		elseif(Player::where([['ip',$request->getClientIp()],['surname',null]])->count() === 1){
			$currentPlayer = Player::where([['ip',$request->getClientIp()],['surname',null]])->first();
		}
		else{
			$currentPlayer = new Player();
			$currentPlayer->ip = $request->getClientIp();
			$currentPlayer->possible_dis = 1;
			$currentPlayer->save();
		}

		// standard possible_disqualification check
		if($currentPlayer->possible_dis === 1 ||
			$currentPlayer->safety_token !== $extraToken ||
			!Hash::check($request->input(['_token']).$request->getClientIp().$request->time,$extraToken) ||
			$request->ip !== $request->getClientIp()
		)
		{
			$possible_dis = 1;
		}
		else{
			$possible_dis = 0;
		}

		// update player info
		$currentPlayer->update([
			'surname' => $request->surname,
			'first_name' => $request->first_name,
			'email' => $request->email,
			'adres' => $request->adres,
			'postalcode' => $request->postalcode,
			'city' => $request->city,
			'time' => $request->time,
			'possible_dis' => $possible_dis
		]);

		$serverTime = round($currentPlayer->end - $currentPlayer->start,1);
		$networkErrorInSeconds = 5;

		// something wrong (possible not users fault) => something wrong, retry
		if($currentPlayer->start === null ||
			$currentPlayer->end === null ||
			$serverTime < ($request->time/10) //||
//			($serverTime >= (($request->time/10)+$networkErrorInSeconds))  // to check in the admin the general network error
			){
			return redirect(route('play'))->with("status","retry");
		}else{
			// outcome all ok -> friend invite
			return redirect(route('play'))->with("status","ok");
		}
	}

	function friend_invite(Request $request){
		return "friend mail";
	}

	function add_fb_player(){
		$user = Socialite::with('facebook')->user();
		// OAuth Two Providers
//		$token = $user->token;

		// OAuth One Providers
		$token = $user->token;
		$tokenSecret = $user->tokenSecret;

		// All Providers
		$user->getId();
		$user->getNickname();
		$user->getName();
		$user->getEmail();
		$user->getAvatar();
	}

	function fb(){
		return Socialite::with('facebook')->redirect();
	}
}
