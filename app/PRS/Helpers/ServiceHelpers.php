<?php

namespace App\PRS\Helpers;

/**
 * Helpers for service elements
 */
class ServiceHelpers
{

    /**
     * Get the binary number between 0,127 that represents de days of the week
     * @param  boolean $monday
     * @param  boolean $tuesday
     * @param  boolean $wednesday
     * @param  boolean $thursday
     * @param  boolean $friday
     * @param  boolean $saturday
     * @param  boolean $sunday
     * @return integer
     */
    public function service_days_to_num(
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

    /**
     * transform service days number to a array of days
     * where active days are set to true.
     * @param  integer $num
     * @return array      array of the days of the week
     */
    public function num_to_service_days($num)
    {
        // we are expecting a number between 0 and 127
        // is basically a decimal to binary conversion
        $days = array(
            'monday'    => false,
            'tuesday'   => false,
            'wednesday' => false,
            'thursday'  => false,
            'friday'    => false,
            'saturday'  => false,
            'sunday'    => false,
        );
        if($num >= 64){
            $days['sunday'] = true;
            $num -= 64;
        }if($num >= 32){
            $days['saturday'] = true;
            $num -= 32;
        }if($num >= 16){
            $days['friday'] = true;
            $num -= 16;
        }if($num >= 8){
            $days['thursday'] = true;
            $num -= 8;
        }if($num >= 4){
            $days['wednesday'] = true;
            $num -= 4;
        }if($num >= 2){
            $days['tuesday'] = true;
            $num -= 2;
        }if($num >= 1){
            $days['monday'] = true;
            $num -= 1;
        }
        return $days;
    }

    /**
     * Get the days of the week in text
     * @param  integer $num service_days number stored in database
     * @return string
     */
    public function get_styled_service_days($num){
        $days = $this->num_to_service_days($num);
        $result = '';
        foreach ($days as $day => $active) {
            if($active){
                $result .= substr($day, 0, 3).', ';
            }
        }
        return '<span class="label label-pill label-default">'.$result.'</span>';
    }

    /**
     * Styling the service status
     * @param  integer  $status  the status code
     * @param  boolean $is_pill tag must be in pill format
     * @return string
     */
    public function get_styled_status($status, $is_pill = true){
    	$tag_type = '';
    	if($is_pill){
    		$tag_type = 'label-pill';
    	}
    	if($status){
    		return '<span class="label '.$tag_type.' label-success">Active</span>';
    	}
    	return '<span class="label '.$tag_type.' label-danger">Inactive</span>';
    }

    /**
     * Styling the service type
     * @param  integer  $type
     * @param  boolean $is_pill
     * @return string
     */
    public function get_styled_type($type, $is_pill = true){
    	$tag_type = '';
    	if($is_pill){
    		$tag_type = 'label-pill';
    	}
    	switch ($type) {
    		case 1:
    			return '<span class="label '.$tag_type.' label-info">chlorine</span>';
    			break;
    		case 2:
    			return '<span class="label '.$tag_type.' label-primary">Salt</span>';
    			break;
    		default:
    			return '<span class="label '.$tag_type.' label-default">Unknown</span>';
    			break;
    	}
    }

    /**
     * Get the country name by the country code
     * @param  string $code string of 2 characters
     * @return string       full name of the country
     */
    public function get_country_by_code($code){
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
    	if(array_key_exists($code, $countries)){
    		return $countries[$code];
    	}
    	return $code;
    }

}
