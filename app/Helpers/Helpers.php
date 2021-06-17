<?php

function pretty_date($date1,$date2){
	$date1 = new DateTime($date1);
	$date2 = new DateTime($date2);
	$interval = $date1->diff($date2);
	$time = $interval->i . ":".$interval->s;
	if($interval->h != 0){
		$time = $interval->h.":".$time;
	}
	return $time;
}