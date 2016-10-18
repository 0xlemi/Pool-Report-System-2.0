<?php

namespace App\PRS\Traits\Model;

use Illuminate\Database\Eloquent\Collection;
use Laravel\Cashier\Billable;

use App\Administrator;

trait BillableAdministrator{

    use Billable;

    /**
     * Mark all the users as inactive (so they cant use them)
     */
    public function setBillibleUsersAsInactive()
    {
        $this->setSupervisorsAsInactive();
        $this->setTechniciansAsInactive();
    }

    /**
     * Mark all the supervisors as inactive (so they cant use them)
     */
    protected function setSupervisorsAsInactive()
    {
        $supervisors = $this->supervisors()->get();
        foreach ($supervisors as $supervisor) {
            $user = $supervisor->user();
            $user->active = 0;
            $user->save();
        }
    }

    /**
     * Mark all the technicians as inactive (so they cant use them)
     */
    protected function setTechniciansAsInactive()
    {
        $technicians = $this->technicians()->get();
        foreach ($technicians as $technician) {
            $user = $technician->user();
            $user->active = 0;
            $user->save();
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
        return $this->techniciansActive()->count()
                + $this->supervisorsActive()->count();
    }


    /**
     * Get all the technicians that are active
     * @param  boolean $active
     * @return  Collection
     */
    public function techniciansActive($active = true)
    {
        $isActive = ($active)? 1:0;
        return $this->techniciansInOrder()->get()
                    ->filter(function($item) use ($isActive){
                        return ($item->user()->active == $isActive);
                    });
    }

    /**
     * Get all the supervisors that are active
     * @param  boolean $active
     * @return Collection
     */
    public function supervisorsActive($active = true)
    {
        $isActive = ($active)? 1:0;
        return $this->supervisorsInOrder()->get()
                    ->filter(function($item) use ($isActive){
                        return ($item->user()->active == $isActive);
                    });
    }

}
