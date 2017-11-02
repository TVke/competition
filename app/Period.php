<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
	protected $dates=['start','end'];

    public function winners(){
    	return $this->belongsTo(Player::class,'winner','id');
    }

    public function scopeCurrentPeriode($query){
	    $current_periode = 1;
	    for($i=1,$ilen=count(Period::all());$i<=$ilen;++$i){
		    $periode = Period::where('id',$i)->first();
		    if(Carbon::now()->between($periode->start,$periode->end)){
			    $current_periode = $periode->id;
			    break;
		    }
	    }
    	return $query->where('id',$current_periode)->first();
    }
}
