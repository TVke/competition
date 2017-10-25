<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['surname','first_name','email','adres','postalcode','city'
	    // control stuff
	    ,'ip','start','end','time','possible_dis','disqualified','safety_token','friend_token'];

	public function scopeQualified($query){
		return $query->where('disqualified',0);
	}
	public function scopeDisQualified($query){
		return $query->where('disqualified',1);
	}
}
