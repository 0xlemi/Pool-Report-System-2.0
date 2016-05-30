<?php
use Carbon\Carbon;

/**
 * Common functions
 */

function flash($title = null, $message = null){
	$flash = app('App\Http\Flash');

	if(func_num_args() == 0){
		return $flash;
	}

	return $flash->info($title, $message);
}

/**
 * Clients Functions
 */

function clients_styled_type($type, $is_pill = true, $long_version = true){
	$tag_type = '';
	$extra_text = '';
	if($is_pill){
		$tag_type = 'label-pill';
	}if($long_version){
		$extra_text = 'House ';
	}
	switch ($type) {
		case 1:
			return '<span class="label '.$tag_type.' label-primary">'.$extra_text.'Owner</span>';
			break;
		case 2:
			return '<span class="label '.$tag_type.' label-warning">'.$extra_text.'Administrator</span>';
			break;
		default:
			return '<span class="label '.$tag_type.' label-default">Unknown</span>';
			break;
	}
}

function languageCode_to_text($code){
	$languageCodes = array(
		'en' => 'English',
		'es' => 'Spanish',
	);
	if(array_key_exists($code, $languageCodes)){
		return $languageCodes[$code];
	}
	return $code;
}

/**
 * Reports Controller functions
 */

function get_image_tag($order){
	switch($order){
		case 1:
			return 'Main Pool Photo';
			break;
		case 2:
			return 'Water Quality';
			break;
		case 3:
			return 'Engine Room';
			break;
		default:
			return 'Extra Photo';
			break;
	}
}

function get_random_name($prefix, $file_type){
	$faker = Faker\Factory::create();
	return $prefix.'_'.str_random(5).'_'.time().'.'.$file_type;

}

function validateDate($date){
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function onTime_tag($on_time){
	switch ($on_time) {
		case '1':
			return '<span class="label label-success">Done on Time</span>';
			break;
		case '2':
			return '<span class="label label-danger">Done Late</span>';
			break;
		case '3':
			return '<span class="label label-warning">Done Early</span>';
			break;
		default:
			return '<span class="label label-default">Unknown</span>';
			break;
	}
}

function readings_tag($value, $is_turbidity = false){
	if(!$is_turbidity){
		switch ($value) {
			case '1':
				return '<span class="label label-info">Very Low</span>';
				break;
			case '2':
				return '<span class="label label-primary">Low</span>';
				break;
			case '3':
				return '<span class="label label-success">Perfect</span>';
				break;
			case '4':
				return '<span class="label label-warning">High</span>';
				break;
			case '5':
				return '<span class="label label-danger">Very High</span>';
				break;
			default:
				return '<span class="label label-default">Unknown</span>';
				break;
		}
	}
	switch ($value) {
		case '1':
			return '<span class="label label-success">Perfect</span>';
			break;
		case '2':
			return '<span class="label label-primary">Low</span>';
			break;
		case '3':
			return '<span class="label label-warning">High</span>';
			break;
		case '4':
			return '<span class="label label-danger">Very High</span>';
			break;
		default:
			return '<span class="label label-default">Unknown</span>';
			break;
	}
}

function format_date($date){
	//****** missing thing is to convert the time to client timezone before sendig *********
	return (new Carbon($date))->format('l jS \\of F Y h:i:s A');
}
