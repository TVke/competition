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


	function friend_invite(Request $request){
		return "friend mail";
	}
}
