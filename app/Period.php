<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
	protected $dates=['start','end'];

    public function winners(){
    	return $this->belongsTo(Player::class,'winner','id');
    }
}
