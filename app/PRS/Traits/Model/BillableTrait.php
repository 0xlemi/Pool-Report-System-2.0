<?php

namespace App\PRS\Traits\Model;

use Illuminate\Database\Eloquent\Collection;
use Laravel\Cashier\Billable;

use App\Administrator;

trait BillableTrait{

    use Billable;

    /**
     * Mark all the users as inactive (so they cant use them)
     */
    public function setBillibleUsersAsInactive()
    {
        $userRoleCompanies = $this->userRoleCompanies()->ofRole('sup', 'tech')->get();
        foreach ($userRoleCompanies as $userRoleCompany) {
            $userRoleCompany->paid = 0;
            $userRoleCompany->save();
        }
    }

    /**
     * Check if you can add another object like supervisor or technician
     * @return boolean
     */
    public function canAddObject()
    {
        // check that the user has a subcription or that has free objects left.
        if($this->subscribedToPlan('pro', 'main') || ($this->objectActiveCount() < $this->free_objects)){
            return true;
        }
        return false;
    }

    /**
     * Objects that are we should bill for, after the free ones are deducted.
     * @return int   number of elements to change for
     */
    public function billableObjects()
    {
        $count = $this->objectActiveCount() - $this->free_objects;
        return max($count,0);
    }

    /**
     * Number of technicans + supervisors that are active
     * @return int
     */
    public function objectActiveCount()
    {
        return $this->userRoleCompanies()
                    ->ofRole('sup', 'tech')->paid(true)->count();
    }

}
