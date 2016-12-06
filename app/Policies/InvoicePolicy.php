<?php

namespace App\Policies;

use App\User;
use App\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Administrator has all permissions
     */
    public function before(User $user)
    {
        if($user->isAdministrator()){
            return true;
        }
    }

    public function list()
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_invoice_index;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_invoice_index;
        }
        return false;
    }

    /**
     * Determine whether the user can view the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return mixed
     */
    public function view(User $user, Invoice $invoice)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_invoice_show;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_invoice_show;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return mixed
     */
    public function delete(User $user, Invoice $invoice)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_invoice_destroy;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
