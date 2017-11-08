<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['last_name','first_name','email','address','postcode','city'
	    // control stuff
	    ,'ip','start','end','time','possible_dis','disqualified','safety_token','friend_token','friend_email','mail_opened','no_more'];
    protected $hidden = ['id','safety_token','created_at','updated_at','friend_token','start','end','possible_dis','disqualified','ip'];

	public function scopeQualified($query){
		return $query->where('disqualified',0);
	}
	public function scopeDisQualified($query){
		return $query->where('disqualified',1);
	}
}
