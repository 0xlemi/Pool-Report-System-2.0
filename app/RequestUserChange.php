<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class RequestUserChange extends Model
{
    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'name',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
