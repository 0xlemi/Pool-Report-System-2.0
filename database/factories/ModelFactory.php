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
    $name = $faker->name;
    $lastName = $faker->lastName;
    return [
        'email' => str_replace(' ', '_', $name).'.'.str_replace(' ', '_',$lastName).'@example.com',
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),

        'name' => $name,
		'last_name' => $lastName,
    	'language' => 'en',
    ];
});

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'website' => $faker->url,
        'facebook' => $faker->word,
        'twitter' => $faker->word,
    	'language' => $faker->languageCode,
		'timezone' => 'America/Mazatlan',
        'latitude' => number_format($faker->latitude(23.049486, 23.061333),6,'.',''),
        'longitude' => number_format($faker->longitude(-109.706683, -109.695697),6,'.',''),
    ];
});

$factory->define(App\Invoice::class, function (Faker\Generator $faker){
    $validCurrencies = config('constants.currencies');
	return [
        'amount' => number_format($faker->numberBetween(75, 500), 2, '.', ''),
        'currency' => $faker->randomElement($validCurrencies),
	];
});

$factory->define(App\Service::class, function (Faker\Generator $faker){
	return [
		'name' => $faker->words($nb = 2, $asText = true),
        'latitude' => number_format($faker->latitude(23.049486, 23.061333),6,'.',''),
        'longitude' => number_format($faker->longitude(-109.706683, -109.695697),6,'.',''),
		'address_line' => $faker->streetAddress,
		'city' => $faker->city,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => $faker->countryCode,
        'comments' => $faker->sentence($nbWords = 6, $variableNbWords = true),
	];
});

$factory->define(App\Equipment::class, function (Faker\Generator $faker){
    $kinds = [
        'Filter',
        'Pump',
        'ComPool',
        'Heater',
        'Heat Pump',
        'Solar Panels',
        'Light',
    ];
    $brands = [
        'Jandy',
        'Polaris',
        'Hayward',
        'Pentair',
        'Savi',
        'Paramount',
    ];
	return [
        'kind' => $faker->randomElement($kinds),
        'type' => $faker->word,
        'brand' => $faker->randomElement($brands),
        'model' => $faker->word.'-'.rand(1000,9999),
        'capacity' => number_format(rand(100,1000000)/100, 2, '.', ''),
        'units' => 'units',
	];
});

$factory->define(App\ServiceContract::class, function (Faker\Generator $faker){
    $validCurrencies = config('constants.currencies');
    return [
        'start' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'service_days' => $faker->numberBetween(0, 127),
        'amount' => number_format($faker->numberBetween(75, 350), 2, '.', ''),
        'currency' => $faker->randomElement($validCurrencies),
        'start_time' => $faker->dateTimeBetween('today', 'now')->format('H:i:s'),
        'end_time' => $faker->dateTimeBetween('now', 'tomorrow')->format('H:i:s'), // between start and end of day
        'active' => $faker->numberBetween(0, 1),
        'comments' => $faker->realText(rand(100,500)),
    ];
});

$factory->define(App\WorkOrder::class, function (Faker\Generator $faker){
    $start = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');
    $validCurrencies = config('constants.currencies');
    return [
        'title' => $faker->word,
        'description' => $faker->realText(rand(100,500)),
		'start' => $start,
        'end' => (rand(0,1)) ? $faker->dateTimeBetween( $start, 'tomorrow')->format('Y-m-d H:i:s') : null,
        'price' => number_format(rand(100,1000000)/100, 2, '.', ''),
        'currency' => $faker->randomElement($validCurrencies),
    ];
});


$factory->define(App\Work::class, function (Faker\Generator $faker){
    return [
        'title' => $faker->word,
        'description' => $faker->realText(rand(100,500)),
        'quantity' => number_format(rand(100,1000000)/100, 2, '.', ''),
        'units' => 'units',
        'cost' => number_format(rand(100,1000000)/100, 2, '.', ''),
    ];
});

$factory->define(App\UserRoleCompany::class, function (Faker\Generator $faker){
	return [
		'type' => $faker->numberBetween(1, 2),
		'cellphone' => $faker->phoneNumber,
		'address' => $faker->address,
		'about' => $faker->sentence($nbWords = 6, $variableNbWords = true)
	];
});

$factory->define(App\Report::class, function (Faker\Generator $faker){
	return [
		'completed' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
		'on_time' => $faker->randomElement(['early', 'onTime', 'late']),
        'latitude' => number_format($faker->latitude(23.049486, 23.061333),6,'.',''),
        'longitude' => number_format($faker->longitude(-109.706683, -109.695697),6,'.',''),
        'altitude' => number_format(($faker->numberBetween(0, 500000)/100),2,'.',''),
        'accuracy' => number_format(($faker->numberBetween(0, 500000)/100),2,'.',''),
	];
});
