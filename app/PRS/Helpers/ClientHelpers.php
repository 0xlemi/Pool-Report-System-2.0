<?php

namespace App\PRS\Helpers;

/**
 * Helpers for client elements
 */
class ClientHelpers
{


    function styledType($type, $is_pill = true, $long_version = true){
    	$tag_type = '';
    	$extra_text = '';
    	if($is_pill){
    		$tag_type = 'label-pill';
    	}if($long_version){
    		$extra_text = 'House ';
    	}
    	switch ($type) {
    		case 1:
    			return '<span class="label '.$tag_type.' label-primary">'.$extra_text.'Owner</span>';
    			break;
    		case 2:
    			return '<span class="label '.$tag_type.' label-warning">'.$extra_text.'Administrator</span>';
    			break;
    		default:
    			return '<span class="label '.$tag_type.' label-default">Unknown</span>';
    			break;
    	}
    }

}
