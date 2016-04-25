<?php
use Carbon\Carbon;

/**
 * Reports Controller functions
 */

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

function fill_database(){
	// factory(App\User::class, 2)->create();
	factory(App\Service::class, 30)->create();
	factory(App\Supervisor::class, 3)->create();
	factory(App\Client::class, 15)->create();
	factory(App\Technician::class, 10)->create();
	factory(App\Report::class, 150)->create();
}

function save_random_image($folder_to_save, $type_of_photo = "nature"){
	$faker = Faker\Factory::create();

	$image_name = 'image_'.str_random(10).'.jpg';
    $img_path = 'storage/images/'.$folder_to_save.'/'.$image_name;
    $tn_img_path = 'storage/images/'.$folder_to_save.'/tn_'.$image_name;
    $width = rand(1000, 1600);
	$height = $width - rand(50, 250);
	$img = Image::make($faker->imageUrl($width, $height, $type_of_photo));
	$img->save('public/'.$img_path);
	$img->resize(300, null, function ($constraint){
	    $constraint->aspectRatio();
	});
	$img->save('public/'.$tn_img_path);
	return [
		'img_path' => $img_path,
		'tn_img_path' => $tn_img_path,
	];
}

function get_random_image($folder_to_save, $folder_to_get, $file_number = 1){
	$image_name = 'image_'.str_random(10).'.jpg';
    $img_path = 'storage/images/'.$folder_to_save.'/'.$image_name;
    $tn_img_path = 'storage/images/'.$folder_to_save.'/tn_'.$image_name;

	$img = Image::make(base_path('resources/images/'.$folder_to_get.'/'.$file_number.'.jpg'));
	$img->save('public/'.$img_path);
	$img->resize(300, null, function ($constraint){
	    $constraint->aspectRatio();
	});
	$img->save('public/'.$tn_img_path);
	return [
		'img_path' => $img_path,
		'tn_img_path' => $tn_img_path,
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