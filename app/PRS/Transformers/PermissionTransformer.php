<?php

namespace App\PRS\Transformers;

use App\Permission;
use App\PRS\Transformers\RoleTransformer;


/**
 * Transformer for the report class
 */
class PermissionTransformer extends Transformer
{

    /**
     * Transform Permission to api friendly array
     * @param  Permission $permission
     * @return array
     */
    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'element' => $permission->element,
            'action' => $permission->action,
            'text' => $permission->text,
        ];
    }
}
