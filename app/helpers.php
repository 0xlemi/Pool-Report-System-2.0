<?php
use Carbon\Carbon;

/**
 * Common functions
 */

function timezoneList()
{
    $regions = array(
        'Africa' => DateTimeZone::AFRICA,
        'America' => DateTimeZone::AMERICA,
        'Antarctica' => DateTimeZone::ANTARCTICA,
        'Aisa' => DateTimeZone::ASIA,
        'Atlantic' => DateTimeZone::ATLANTIC,
        'Europe' => DateTimeZone::EUROPE,
        'Indian' => DateTimeZone::INDIAN,
        'Pacific' => DateTimeZone::PACIFIC
    );
    $timezones = array();
    foreach ($regions as $name => $mask)
    {
        $zones = DateTimeZone::listIdentifiers($mask);
        foreach($zones as $timezone)
        {
    		// Lets sample the time there right now
    		$time = new DateTime(NULL, new DateTimeZone($timezone));
    		// Us dumb Americans can't handle millitary time
    		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
    		// Remove region name and add a sample time
    		$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
    	}
    }
    return $timezones;
}

function flash($title = null, $message = null){
	$flash = app('App\Http\Flash');

	if(func_num_args() == 0){
		return $flash;
	}

	return $flash->info($title, $message);
}

/**
 * Makes Multidimentional arrays simple keeping the keys
 * @param  array $array
 * @param  string $prefix
 * @return array          the flatten array
 */
function array_flat($array, $prefix = '')
{
    $result = array();

    foreach ($array as $key => $value)
    {
        $new_key = $prefix . (empty($prefix) ? '' : '.') . $key;

        if (is_array($value))
        {
            $result = array_merge($result, array_flat($value, $new_key));
        }
        else
        {
            $result[$new_key] = $value;
        }
    }

    return $result;
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
