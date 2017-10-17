<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['surname','first_name','email','adres','postalcode','city'
	    // control stuff
	    ,'ip','start','end','possible_dis','disqualified','safety_token','friend_token'];
}
