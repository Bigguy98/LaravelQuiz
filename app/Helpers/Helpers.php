<?php

function pretty_date($date1,$date2){
	$date1 = new DateTime($date1);
	$date2 = new DateTime($date2);
	$interval = $date1->diff($date2);
	$minutes = $interval->i;
	$seconds = $interval->s;
	if(strlen($seconds) == 1){
		$seconds = 0 . $seconds;
	}
	$time = $minutes . ":". $seconds;
	if($interval->h != 0){
		$time = $interval->h.":".$time;
	}
	return $time;
}

function percentage($correct_answers,$answers){
	return round(($correct_answers/$answers)*100);
}

function progressClass($correct_answers,$answers){
	$percentage = percentage($correct_answers,$answers);
	if($percentage <= 60){
		return 'danger';
	}
	if($percentage >= 61 && $percentage <= 70){
		return 'warning';
	}
	if($percentage >= 71 && $percentage <= 80){
		return 'success';
	}
	if($percentage >= 81){
		return 'info';
	}
}

function timeClass($date1,$date2,$answers){
	$time = pretty_date($date1,$date2);
	$parts = explode(':', $time);
	if(isset($parts[2])){
		return 'danger';
	}
	$number = number_format(($parts[0] + $parts[1] / 60), 2, '.', '');
	if($number < $answers/2){
		return 'info';
	}
	if($number >= $answers/2 && $number < $answers * 0.75){
		return 'success';
	}
	if($number >= $answers * 0.75 && $number < $answers){
		return 'warning';
	}
	if($number > $answers){
		return 'danger';
	}
}