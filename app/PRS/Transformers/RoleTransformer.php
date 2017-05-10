<?php

namespace App\PRS\Transformers;

use App\Role;
use App\PRS\Transformers\ImageTransformer;


/**
 * Transformer for the role class
 */
class RoleTransformer extends Transformer
{

    /**
     * Transform Role to api friendly array
     * @param  Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'name' => $role->name,
            'icon' => $role->icon,
            'text' => $role->text,
        ];
    }
}
