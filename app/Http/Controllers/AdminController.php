<?php

namespace App\Http\Controllers;

use App\Period;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
//    	return $request;
	    $request->validate([
		    'start-1' => 'required|date_format:d-m-Y|before:end-1',
		    'end-1' => 'required|date_format:d-m-Y|after:start-1|before_or_equal:start-2',

		    'start-2' => 'required|date_format:d-m-Y|after_or_equal:end-1|before:end-2',
		    'end-2' => 'required|date_format:d-m-Y|after:start-2|before_or_equal:start-3',

		    'start-3' => 'required|date_format:d-m-Y|after_or_equal:end-2|before:end-3',
		    'end-3' => 'required|date_format:d-m-Y|after:start-3|before_or_equal:start-4',

		    'start-4' => 'required|date_format:d-m-Y|after_or_equal:end-3|before:end-4',
		    'end-4' => 'required|date_format:d-m-Y|after:start-4',
	    ]);
	    $first = Period::where('id',1)->first();
	    $second = Period::where('id',2)->first();
	    $third = Period::where('id',3)->first();
	    $fourth = Period::where('id',4)->first();


	    $first->update([
		    'start' => Carbon::parse($request->input(['start-1'])),
		    'end' => Carbon::parse($request->input(['end-1'])),
	    ]);
	    $second->update([
		    'start' => Carbon::parse($request->input(['start-2'])),
		    'end' => Carbon::parse($request->input(['end-2'])),
	    ]);
	    $third->update([
		    'start' => Carbon::parse($request->input(['start-3'])),
		    'end' => Carbon::parse($request->input(['end-3'])),
	    ]);
	    $fourth->update([
		    'start' => Carbon::parse($request->input(['start-4'])),
		    'end' => Carbon::parse($request->input(['end-4'])),
	    ]);
    	return redirect(route('admin'));
    }

    function player(Player $player){
    	$player->update([
    		'disqualified' => '1'
	    ]);
    	return redirect(route('admin'));
    }

    function playersToExcel(){
    	Excel::create('Deelnemers', function($excel) {
		    $excel->sheet('Deelnemers', function($sheet) {
			    $sheet->fromModel(Player::qualified()->latest()->get());
		    });

	    })->download('xlsx');
    }
}
