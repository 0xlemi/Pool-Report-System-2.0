<?php


use Carbon\Carbon;
use App\helpers;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'language' => $faker->languageCode,
    ];
});

$factory->define(App\Service::class, function (Faker\Generator $faker){

	// time between 7am and 8pm
	$start_time = $faker->numberBetween(25200, 72000);

	// get a random user_id that exists in database
	$user_id = get_random_table_id('users');

    // generate and save image and tn_image
	$img = get_random_image('service', 'service', rand(1, 20));

	return [
		'name' => $faker->words($nb = 2, $asText = true),
		'address_line' => $faker->streetAddress,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => $faker->country,
        'type' => $faker->numberBetween(1, 2), // not sure what types
        'service_days' => $faker->numberBetween(0, 127),
        'amount' => $faker->numberBetween(75, 350),
        'currency' => $faker->currencyCode,
        'start_time' => $start_time,
        'end_time' => $faker->numberBetween($start_time, 86399), // between start and end of day
        'status' => $faker->numberBetween(0, 1),
        'image' => $img['img_path'],
        'tn_image' => $img['tn_img_path'],
        'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'user_id' => $user_id,
	];
});

$factory->define(App\Supervisor::class, function (Faker\Generator $faker){

	// get a random user_id that exists in database
    $user_id = get_random_table_id('users');

    // generate and save image and tn_image
    $img = get_random_image('supervisor', 'supervisor', rand(1, 5));

	return [
		'name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'address' => $faker->address,
		'email' => $faker->safeEmail,
		'password' => bcrypt('password'),
		'image' => $img['img_path'],
        'tn_image' => $img['tn_img_path'],
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
		'user_id' => $user_id,
	];
});

$factory->define(App\Technician::class, function (Faker\Generator $faker){

	// get a random user_id that exists in database
    $supervisor_id = get_random_table_id('supervisors');

    // generate and save image and tn_image
	$img = get_random_image('technician', 'technician', rand(1, 20));

	return [
		'name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'address' => $faker->address,
		'username' => $faker->word.str_random(5),
		'password' => bcrypt('password'),
		'image' => $img['img_path'],
        'tn_image' => $img['tn_img_path'],
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
		'supervisor_id' => $supervisor_id,
	];
});

$factory->define(App\Client::class, function (Faker\Generator $faker){

	// woman or men
	$gender = (rand(0,1)) ? 'male':'female';

    // generate and save image and tn_image
	$img = get_random_image('client', 'client/'.$gender, rand(1, 20));


	return [
		'name' => $faker->firstName($gender) ,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'email' => $faker->safeEmail,
		'password' => bcrypt('password'),
		'image' => $img['img_path'],
        'tn_image' => $img['tn_img_path'],
		'type' => $faker->numberBetween(1, 2),
		'email_preferences' => $faker->numberBetween(1, 4),
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
	];
});

$factory->define(App\Report::class, function (Faker\Generator $faker){

	// get a random user_id that exists in database
    $service_id = get_random_table_id('services');

    //****** i need a technician to belong to the same user as the service ****//
    //
    $technician_id = get_random_table_id('technicians');

    // generate and save image and tn_image
	$img1 = get_random_image('report', 'pool_photo_1', rand(1, 50));
	$img2 = get_random_image('report', 'pool_photo_2', rand(1, 50));
	$img3 = get_random_image('report', 'pool_photo_3', rand(1, 50));

	return [
		'completed' => Carbon::now(),
		'on_time' => $faker->numberBetween(0, 2),
        'ph' => $faker->numberBetween(1, 5),
        'clorine' => $faker->numberBetween(1, 5),
        'temperature' => $faker->numberBetween(1, 5),
        'turbidity' => $faker->numberBetween(1, 5),
        'salt' => $faker->numberBetween(1, 5),
        'image_1' => $img1['img_path'],
        'image_2' => $img2['img_path'],
        'image_3' => $img3['img_path'],
        'tn_image_1' => $img1['tn_img_path'],
        'tn_image_2' => $img2['tn_img_path'],
        'tn_image_3' => $img3['tn_img_path'],
        'latitude' => $faker->latitude(-90, 90),
        'longitude' => $faker->longitude(-180, 180),
        'altitude' => $faker->numberBetween(0, 500000)/100,
        'accuracy' => $faker->numberBetween(0, 500000)/100,
        'service_id' => $service_id,
        'technician_id' => $technician_id,
	];
});

$factory->define(App\Image::class, function (Faker\Generator $faker){

});