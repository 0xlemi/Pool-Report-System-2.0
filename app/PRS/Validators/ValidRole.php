<?php

namespace App\PRS\Validators;

use App\Role;

class ValidRole
{

    public function validate($attribute, $value)
    {
        return Role::all()->contains('name', $value);
    }

    public function message($message, $attribute)
    {
        $roles = Role::all()->pluck('name')->toArray();
        return "The {$attribute} is not a supported role. Suported roles: ".implode(', ', $roles);
    }

}
