<?php

namespace App\Http\Controllers;

use App\Period;
use App\Player;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
		$token = $request->input(['_token']);
		$encryptedToken = hash("md5",$request->getClientIp().$request->input(['_token']));
		$currentTime = Carbon::now();

		// adding new Player
		$player = new Player();
		$player->ip = $request->getClientIp();

		// checks of foul play
		if($request->ip !== $request->getClientIp() || !$request->is('start')){
			$player->possible_dis = 1;
		}

		$player->start = $currentTime->toDateTimeString();
		$player->safety_token = $encryptedToken;
		$player->save();
		return $encryptedToken;
	}
	function end(Request $request){
		$extraToken = $request->et;
		$newToken = hash("md5",$request->input(['_token']).$request->getClientIp());
		$currentTime = Carbon::now();

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
			$extraToken !== hash("md5",$request->getClientIp().$request->input(['_token'])) ||
			$request->ip !== $request->getClientIp())
		{
			$poss_dis = 1;
		}
		else{
			$poss_dis = 0;
		}

		// updating player with the IP address
		$currentPlayer->update([
			'end' => $currentTime->toDateTimeString(),
			'safety_token' => $newToken,
			'possible_dis' => $poss_dis
		]);
		return $newToken;
	}

	function add_player(){
		// add player info to IP


	}
}
