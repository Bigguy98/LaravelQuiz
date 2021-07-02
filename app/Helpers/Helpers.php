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

function percentage($correct_answers,$answers){
	return round(($correct_answers/$answers)*100);
}

function prgressClass($correct_answers,$answers){
	$percentage = percentage($correct_answers,$answers);
	if($percentage <= 60){
		return 'danger';
	}
	if($percentage > 61 && $percentage <= 70){
		return 'warning';
	}
	if($percentage > 70 && $percentage <= 80){
		return 'success';
	}
	if($percentage > 80){
		return 'info';
	}
}