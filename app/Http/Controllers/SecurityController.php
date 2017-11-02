<?php

namespace App\Http\Controllers;

use App\Period;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
	function start(Request $request){
		$currentTime = round(microtime(true),4);
		$encryptedToken = Hash::make($request->getClientIp().$request->input(['_token']));

		// adding new Player
		$player = new Player();
		$player->ip = $request->getClientIp();

		// checks of foul play
		if(!$request->is('start')){
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
		if(Player::where([['safety_token',$extraToken],['last_name',null]])->count() === 1){
			$currentPlayer = Player::where([['safety_token',$extraToken],['last_name',null]])->first();
		}
		elseif(Player::where([['ip',$request->getClientIp()],['last_name',null]])->count() === 1){
			$currentPlayer = Player::where([['ip',$request->getClientIp()],['last_name',null]])->first();
		}
		else{
			$newPlayer = new Player();
			$newPlayer->ip = $request->getClientIp();
			$newPlayer->possible_dis = 1;
			$currentPlayer = $newPlayer->save();
		}
		$poss_dis = 0;
		// check foul play
		if($currentPlayer->possible_dis === 1 ||
			$currentPlayer->safety_token !== $extraToken ||
			!Hash::check($request->getClientIp().$request->input(['_token']), $extraToken)
		)
		{
			$poss_dis = 1;
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
		// check player info
		$request->validate([
			'first_name' => 'required|string|min:2|max:255',
			'last_name' => 'required|string|min:2|max:255',
			'email' => 'required|unique:players|email|min:5|max:255',
			'address' => 'required|string|min:2|max:255',
			'postcode' => 'required|alpha_num|min:4|max:6',
			'city' => 'required|string|min:2|max:255',
		]);

		$extraToken = $request->et;

		// check if player exists
		if(Player::where([['safety_token',$extraToken],['last_name',null]])->count() === 1){
			$currentPlayer = Player::where([['safety_token',$extraToken],['last_name',null]])->first();
		}
		elseif(Player::where([['ip',$request->getClientIp()],['last_name',null]])->count() === 1){
			$currentPlayer = Player::where([['ip',$request->getClientIp()],['last_name',null]])->first();
		}
		else{ // no loss of data
			$currentPlayer = new Player();
			$currentPlayer->ip = $request->getClientIp();
			$currentPlayer->possible_dis = 1;
			$currentPlayer->save();
		}

		// standard possible_disqualification check
		if($currentPlayer->possible_dis === 1 ||
			$currentPlayer->safety_token !== $extraToken ||
			!Hash::check($request->input(['_token']).$request->getClientIp().$request->time,$extraToken)
		)
		{
			$possible_dis = 1;
		}
		else{
			$possible_dis = 0;
		}

		// update player info
		$currentPlayer->update([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'address' => $request->address,
			'postcode' => $request->postcode,
			'city' => $request->city,
			'time' => $request->time,
			'possible_dis' => $possible_dis
		]);

		$serverTime = round($currentPlayer->end - $currentPlayer->start,1);
		$networkErrorInSeconds = 5;

		// player hasn't played the game yet
		if($currentPlayer->start === null && $currentPlayer->end === null){
			return redirect(route('play'))->with("status","not_played");
		}

		// something wrong (possible not users fault) => something wrong, retry
		if($currentPlayer->start === null ||
			$currentPlayer->end === null ||
			$serverTime < ($request->time/10) ||
			($serverTime >= (($request->time/10)+$networkErrorInSeconds))  // to check in the admin the general network error
		){
			return redirect(route('play'))->with("status","retry");
		}

		// set player cookie
		$minutesTillEndOfPeriod = Carbon::now()->diffInMinutes(Period::currentPeriode()->end);
		$tokenToRemember = Hash::make($request->input(['_token']).$request->getClientIp().$currentPlayer->time);
		if($currentPlayer->safety_token){
			$tokenToRemember = $currentPlayer->safety_token;
		}
		Cookie::queue('game_player', $tokenToRemember, $minutesTillEndOfPeriod);

		// outcome all ok -> friend invite
		return redirect(route('play'))->with("status","ok");
	}


//	function add_fb_player(){
//		$user = Socialite::with('facebook')->user();
//		// OAuth Two Providers
////		$token = $user->token;
//
//		// OAuth One Providers
//		$token = $user->token;
//		$tokenSecret = $user->tokenSecret;
//
//		// All Providers
//		$user->getId();
//		$user->getNickname();
//		$user->getName();
//		$user->getEmail();
//		$user->getAvatar();
//	}
//
//	function fb(){
//		return Socialite::with('facebook')->redirect();
//	}
}
