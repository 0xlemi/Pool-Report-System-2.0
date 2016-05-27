<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\Transformer;
use App\User;

/**
 *
 */
class UserTransformer extends Transformer
{

    /**
    * format to transform a lesson
    * @param  User   $user
    * @return array
    */
    public function transform(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'company_name' => $user->company_name,
            'website' => $user->website,
            'facebook' => $user->facebook,
            'twitter' => $user->twitter,
            'language' => $user->language,
            'timezone' => $user->timezone,
        ];
    }

}
