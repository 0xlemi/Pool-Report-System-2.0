<?php
function set_up_database_examples(){
	factory(App\User::class, 2)->create();
	factory(App\Service::class, 60)->create();
	factory(App\Supervisor::class, 10)->create();
	factory(App\Service::class, 30)->create();
	factory(App\Service::class, 30)->create();
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