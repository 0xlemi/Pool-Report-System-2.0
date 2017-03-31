<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\PRS\Helpers\UserRoleCompanyHelpers;
use App\UserRoleCompany;


/**
 * Transformer for the userRoleCompany class
 */
class UserRoleCompanyDatatableTransformer extends Transformer
{

    private $helper;

    public function __construct(UserRoleCompanyHelpers $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Transform client for today's route to datatable friendly array
     * @param  client $userRoleCompany
     * @return array
     */
    public function transform(UserRoleCompany $userRoleCompany)
    {
        $user = $userRoleCompany->user;
        return [
            'id' => $userRoleCompany->seq_id,
            'name' => $user->fullName,
            'email' => $user->email,
            'type' => $this->helper->styledTypeClient($user->type, true, false),
            'cellphone' => $user->cellphone,
            'role' => $userRoleCompany->role->text,
        ];
    }

}
