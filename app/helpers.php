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
 * Service Functions
 */

function get_styled_service_days($num){
	// we are expecting a number between 0 and 127
    // is basically a decimal to binary conversionS
    $days = array();
    if($num >= 64){
        array_unshift($days, 'sun');
        $num -= 64;
    }if($num >= 32){
        array_unshift($days, 'sat');
        $num -= 32;
    }if($num >= 16){
        array_unshift($days, 'fri');
        $num -= 16;
    }if($num >= 8){
        array_unshift($days, 'thu');
        $num -= 8;
    }if($num >= 4){
        array_unshift($days, 'wen');
        $num -= 4;
    }if($num >= 2){
        array_unshift($days, 'tue');
        $num -= 2;
    }if($num >= 1){
        array_unshift($days, 'mon');
        $num -= 1;
    }
    $result = '';
    foreach ($days as $day) {
    	$result .= $day.', ';
    }
    return '<span class="label label-pill label-default">'.$result.'</span>';
}

function get_styled_type($type){
	switch ($type) {
		case 1:
			return '<span class="label label-pill label-primary">Clorine</span>';
			break;
		case 2:
			return '<span class="label label-pill label-default">Salt</span>';
			break;
		default:
			return '<span class="label label-pill label-default">Unknown</span>';
			break;
	}
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


/**
 * Database factory and seed functions
 */

function get_random_image($folder_to_save, $folder_to_get, $file_number = 1){
	$image_name = 'image_'.str_random(10).'.jpg';
    $img_path = 'storage/images/'.$folder_to_save.'/'.$image_name;
    $tn_img_path = 'storage/images/'.$folder_to_save.'/tn_'.$image_name;
    $xs_img_path = 'storage/images/'.$folder_to_save.'/xs_'.$image_name;

	$img = Intervention::make(base_path('resources/images/'.$folder_to_get.'/'.$file_number.'.jpg'));
	$img->save('public/'.$img_path);

	$img->fit(300);
	$img->save('public/'.$tn_img_path);

	$img->fit(64);
	$img->save('public/'.$xs_img_path);

	return [
		'img_path' => $img_path,
		'tn_img_path' => $tn_img_path,
		'xs_img_path' => $xs_img_path,
	];
}

function get_random_table_id($table){
	$faker = Faker\Factory::create();
	
	$table_ids = \DB::table($table)->select('id')->get();
    return $faker->randomElement($table_ids)->id;
}

function get_random_service_form_user_id($user_id){
	$faker = Faker\Factory::create();

	$table_ids = \DB::table('services')->select('id')->where('user_id', '=', $user_id)->get();
    return $faker->randomElement($table_ids)->id;
}

function truncate_tables($toTruncate){
	DB::unprepared('SET FOREIGN_KEY_CHECKS = 0;');
	foreach($toTruncate as $table){
		DB::table($table)->truncate();
	}
	DB::unprepared('SET FOREIGN_KEY_CHECKS = 1;');
}

function delete_in_public_storage($foldersToDelete){
	foreach ($foldersToDelete as $folder) {
		$files = glob(public_path('storage/images/'.$folder.'/*')); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
		    unlink($file); // delete file
		}
	}
}