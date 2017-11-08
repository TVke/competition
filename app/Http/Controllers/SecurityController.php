<?php

namespace App\Http\Controllers;

use App\Mail\GrantNewChange;
use App\Mail\inviteFriend;
use App\Period;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
		){
			$possible_dis = 1;
		}
		else{
			$possible_dis = 0;
		}

		// update player info
		$currentPlayer->update([
			'first_name' => ucfirst($request->first_name),
			'last_name' => $request->last_name,
			'email' => $request->email,
			'address' => $request->address,
			'postcode' => $request->postcode,
			'city' => $request->city,
			'time' => $request->time,
			'possible_dis' => $possible_dis,
		]);

		if(Player::where([['friend_email',$request->email],['mail_opened',1]])->count() > 0){
			$friendFrom = Player::where([['friend_email',$request->email],['mail_opened',1]])->first();
			Mail::to($friendFrom->email)->send(new GrantNewChange());
		}

		$serverTime = round($currentPlayer->end - $currentPlayer->start,1);
		$networkErrorInSeconds = 5;

		// something wrong (possible not users fault) => something wrong, retry
		if($currentPlayer->start === null ||
			$currentPlayer->end === null ||
			$serverTime < ($request->time/10) ||
			($serverTime >= (($request->time/10)+$networkErrorInSeconds))  // to check in the admin the general network error
		){
			return redirect(route('play'))->with("retry",'retry');
		}

		// set player cookie
		$minutesTillEndOfPeriod = Carbon::now()->diffInMinutes(Period::currentPeriode()->end);
		$tokenToRemember = Hash::make($request->input(['_token']).$request->getClientIp().$currentPlayer->time);
		if($currentPlayer->safety_token){
			$tokenToRemember = $currentPlayer->safety_token;
		}
		Cookie::queue('game_player', $tokenToRemember, $minutesTillEndOfPeriod);

		// outcome all ok -> friend invite
		$player = Player::where("id",$currentPlayer->id)->first();
		return redirect(route('play'))->with("ok",$player->id);
	}

	function second_play(Request $request){

		if(Cookie::get('game_player')){ // checks if cookie is set
			if(Player::where('safety_token',Cookie::get('game_player'))->count() > 0){ // checks if player from cookie exists

				$cookie = Player::where('safety_token',Cookie::get('game_player'))->first();

				if($cookie->mail_opened === 1 && (Player::where('email',$cookie->friend_email)->count() > 0)){
					session()->forget('newChange');
					$currentPlayer = new Player();
					$currentPlayer->ip = $request->getClientIp();
					$currentPlayer->first_name = $cookie->first_name;
					$currentPlayer->last_name = $cookie->last_name;
					$currentPlayer->email = $cookie->email;
					$currentPlayer->address = $cookie->address;
					$currentPlayer->postcode = $cookie->postcode;
					$currentPlayer->city = $cookie->city;
					$currentPlayer->time = $request->time;
					$currentPlayer->no_more = 1;
					$currentPlayer->save();

					$cookie->update(['no_more'=>1]);
					session()->put(['secondPlayed'=>'secondPlayed']);
				}
			}
		}

		return redirect(route('play'));
	}

	function friend_invite(Request $request,Player $player){
		$request->validate([
			'friend_email' => 'required|email|unique:players|unique:players,email|min:5|max:255',
		]);

		$currentPlayer = $player;
		if(Cookie::get('game_player')){
			$currentPlayer = Player::where('safety_token', Cookie::get('game_player'))->first();
			if($currentPlayer->id !== $player->id){
				return redirect(route('play'))->with("retry",'retry');
			}
		}
		$token = md5($currentPlayer->email.$request->friend_email.$currentPlayer->safety_token);
		$currentPlayer->update([
			'friend_token' => $token,
			'friend_email' => $request->friend_email,
		]);

		Mail::to($request->friend_email)->send(new inviteFriend($currentPlayer->id,$token));
		return redirect(route('play'))->with("friend_added",$request->friend_email);
	}

	function friend_check(Player $friend){
		if(md5($friend->email.$friend->friend_email.$friend->safety_token) === $friend->friend_token){
			$friend->update(['mail_opened'=>1]);
		}
		return redirect(route('home'));
	}
}
