<?php

namespace App\PRS\Observers;

use App\Equipment;
use App\Jobs\DeleteImagesFromS3;
use App\Notifications\AddedEquipmentNotification;

class EquipmentObserver
{
    /**
     * Listen to the Equipment created event.
     *
     * @param  Equipment  $equipment
     * @return void
     */
    public function created(Equipment $equipment)
    {
        // Notifications
        $urc = auth()->user()->selectedUser;
        $people = $urc->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new AddedEquipmentNotification($equipment, $urc));
        }
        foreach ($equipment->service->userRoleCompanies as $client) {
            $client->notify(new AddedEquipmentNotification($equipment, $urc));
        }
    }

    /**
     * Listen to the Equipment deleting event.
     *
     * @param  Equipment  $equipment
     * @return void
     */
    public function deleted(Equipment $equipment)
    {
        dispatch(new DeleteImagesFromS3($equipment->images));
    }
}
