<?php


use Carbon\Carbon;
use App\helpers;
use App\Technician;

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
	// $start_time = $faker->numberBetween(25200, 72000);
	// dateTimeBetween('today', 'now');

	// get a random user_id that exists in database
	$user_id = get_random_table_id('users');

	return [
		'name' => $faker->words($nb = 2, $asText = true),
		'address_line' => $faker->streetAddress,
		'city' => $faker->city,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => $faker->countryCode,
        'type' => $faker->numberBetween(1, 2), // not sure what types
        'service_days' => $faker->numberBetween(0, 127),
        'amount' => $faker->numberBetween(75, 350),
        'currency' => $faker->currencyCode,
        'start_time' => $faker->dateTimeBetween('today', 'now')->format('H:i:s'),
        'end_time' => $faker->dateTimeBetween('now', 'tomorrow')->format('H:i:s'), // between start and end of day
        'status' => $faker->numberBetween(0, 1),
        'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'user_id' => $user_id,
	];
});

$factory->define(App\Supervisor::class, function (Faker\Generator $faker){

	// get a random user_id that exists in database
    $user_id = get_random_table_id('users');

	return [
		'name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'address' => $faker->address,
		'email' => $faker->safeEmail,
		'password' => bcrypt('password'),
		'language' => $faker->languageCode,
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
		'user_id' => $user_id,
	];
});

$factory->define(App\Technician::class, function (Faker\Generator $faker){

	// get a random user_id that exists in database
    $supervisor_id = get_random_table_id('supervisors');

	return [
		'name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'address' => $faker->address,
		'username' => $faker->word.str_random(5),
		'password' => bcrypt('password'),
		'language' => $faker->languageCode,
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
		'supervisor_id' => $supervisor_id,
	];
});

$factory->define(App\Client::class, function (Faker\Generator $faker){

	return [
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'email' => $faker->safeEmail,
		'password' => bcrypt('password'),
		'type' => $faker->numberBetween(1, 2),
		'email_preferences' => $faker->numberBetween(1, 4),
		'language' => $faker->languageCode,
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
	];
});

$factory->define(App\Report::class, function (Faker\Generator $faker){

	// random technician id
	$technician_id = get_random_table_id('technicians');

	// get the user id in of the random technician
	$user_id = Technician::findOrFail($technician_id)->user()->id;

	// get a random service that shares the same user_id
	// as the technician
	$service_id = get_random_service_form_user_id($user_id);

	return [
		'completed' => Carbon::now(),
		'on_time' => $faker->numberBetween(1, 3),
        'ph' => $faker->numberBetween(1, 5),
        'clorine' => $faker->numberBetween(1, 5),
        'temperature' => $faker->numberBetween(1, 5),
        'turbidity' => $faker->numberBetween(1, 4),
        'salt' => $faker->numberBetween(1, 5),
        'latitude' => $faker->latitude(-90, 90),
        'longitude' => $faker->longitude(-180, 180),
        'altitude' => $faker->numberBetween(0, 500000)/100,
        'accuracy' => $faker->numberBetween(0, 500000)/100,
        'service_id' => $service_id,
        'technician_id' => $technician_id,
	];
});

