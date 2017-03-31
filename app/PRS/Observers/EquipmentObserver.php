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
        // // Notify:
        //     //  System Admin,
        //     //  All Admin Supervisors,
        //     //  Clients related to the service
        // $authUser = \Auth::user();
        // $admin = $equipment->service()->admin();
        // $admin->user->notify(new AddedEquipmentNotification($equipment, $authUser));
        // foreach ($admin->supervisors as $supervisor) {
        //     $supervisor->user->notify(new AddedEquipmentNotification($equipment, $authUser));
        // }
        // foreach ($equipment->service()->clients as $client) {
        //     $client->user->notify(new AddedEquipmentNotification($equipment, $authUser));
        // }
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
