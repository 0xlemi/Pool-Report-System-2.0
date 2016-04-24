<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
    	'report_id',
    	'technician_id',
    	'supervisor_id',
    	'client_id',
    	'comment',
    	'chat_id_parent',
    ];
}
