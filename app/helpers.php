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

function service_days_to_num(
	$monday, $tuesday, $wednesday, 
	$thursday, $friday, $saturday, $sunday){
	// basicamente es un numero binario de 7 digitos, el numero maximo posible es 2^7 = 128
    $num = 0;
    if($monday){
        $num += 1;
    }if($tuesday){
        $num += 2;
    }if($wednesday){
        $num += 4;
    }if($thursday){
        $num += 8;
    }if($friday){
        $num += 16;
    }if($saturday){
        $num += 32;
    }if($sunday){
        $num += 64;
    }
    return $num;
}

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

function get_styled_status($status, $is_pill = true){
	$tag_type = '';
	if($is_pill){
		$tag_type = 'label-pill';
	}
	if($status){
		return '<span class="label '.$tag_type.' label-success">Active</span>';
	}
	return '<span class="label '.$tag_type.' label-danger">Inactive</span>';
}

function get_styled_type($type, $is_pill = true){
	$tag_type = '';
	if($is_pill){
		$tag_type = 'label-pill';
	}
	switch ($type) {
		case 1:
			return '<span class="label '.$tag_type.' label-info">Clorine</span>';
			break;
		case 2:
			return '<span class="label '.$tag_type.' label-primary">Salt</span>';
			break;
		default:
			return '<span class="label '.$tag_type.' label-default">Unknown</span>';
			break;
	}
}

function get_country_by_code($code){
	$countries = array(
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
	return $countries[$code];
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