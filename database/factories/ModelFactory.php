<?php


use Carbon\Carbon;

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
    // factory dosnt work unless userable_id and userable_type are added
    return [
        'email' => $faker->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
    ];
});

$factory->define(App\Administrator::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'company_name' => $faker->company,
        'website' => $faker->url,
        'facebook' => $faker->word,
        'twitter' => $faker->word,
    	'language' => $faker->languageCode,
		'timezone' => 'America/Mazatlan',
    ];
});

$factory->define(App\Service::class, function (Faker\Generator $faker){
	// time between 7am and 8pm
	// $start_time = $faker->numberBetween(25200, 72000);
	// dateTimeBetween('today', 'now');
	return [
		'name' => $faker->words($nb = 2, $asText = true),
		'address_line' => $faker->streetAddress,
		'city' => $faker->city,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => $faker->countryCode,
        'type' => $faker->numberBetween(1, 2), // not sure what types
        'service_days' => $faker->numberBetween(0, 127),
        'amount' => number_format($faker->numberBetween(75, 350), 2, '.', ''),
        'currency' => $faker->currencyCode,
        'start_time' => $faker->dateTimeBetween('today', 'now')->format('H:i:s'),
        'end_time' => $faker->dateTimeBetween('now', 'tomorrow')->format('H:i:s'), // between start and end of day
        'status' => $faker->numberBetween(0, 1),
        'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
	];
});

$factory->define(App\Supervisor::class, function (Faker\Generator $faker){
	return [
        'name' => $faker->name,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
    	'language' => $faker->languageCode,
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
	];
});

$factory->define(App\Technician::class, function (Faker\Generator $faker){
	return [
        'name' => $faker->name,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'address' => $faker->address,
    	'language' => $faker->languageCode,
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
	];
});

$factory->define(App\Client::class, function (Faker\Generator $faker){
	return [
        'name' => $faker->name,
		'last_name' => $faker->lastName,
		'cellphone' => $faker->phoneNumber,
		'type' => $faker->numberBetween(1, 2),
    	'language' => $faker->languageCode,
		'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
	];
});

$factory->define(App\Report::class, function (Faker\Generator $faker){
	return [
		'completed' => Carbon::now(),
		'on_time' => $faker->numberBetween(1, 3),
        'ph' => $faker->numberBetween(1, 5),
        'clorine' => $faker->numberBetween(1, 5),
        'temperature' => $faker->numberBetween(1, 5),
        'turbidity' => $faker->numberBetween(1, 4),
        'salt' => $faker->numberBetween(1, 5),
        'latitude' => number_format($faker->latitude(-90, 90),6,'.',''),
        'longitude' => number_format($faker->longitude(-180, 180),6,'.',''),
        'altitude' => number_format(($faker->numberBetween(0, 500000)/100),2,'.',''),
        'accuracy' => number_format(($faker->numberBetween(0, 500000)/100),2,'.',''),
	];
});
