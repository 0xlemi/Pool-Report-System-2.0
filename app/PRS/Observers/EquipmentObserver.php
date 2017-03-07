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
        $admin = $equipment->service()->admin();
        $admin->user->notify(new AddedEquipmentNotification($equipment, \Auth::user()));
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
