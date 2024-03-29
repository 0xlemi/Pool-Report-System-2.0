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
            'last_name' => $user->last_name,
            'email' => $user->email,
            'language' => $user->language,
            'verified' => $user->verified,
        ];
    }

}
