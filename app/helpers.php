<?php
/*
    |--------------------------------------------------------------------------
    | Custom Helper functions
    |--------------------------------------------------------------------------
    |
    | These functions are available throughout this project and can be helpfull
	| when the Laravel helper functions are not enough.
    |
*/

/**
 * creates a string from a given time in milliseconds
 *
 * @param $timeInMilliseconds
 * @return string
 */

function timeFormat($timeInMilliseconds){
	$milli = $timeInMilliseconds%10;
	$seconds = str_pad($timeInMilliseconds/10%60, 2, '0', STR_PAD_LEFT);
	$minutes = str_pad($timeInMilliseconds/600%60, 2, '0', STR_PAD_LEFT);
	return $minutes.":".$seconds.",".$milli;
}