<?php

namespace App\PRS\Traits\Controller;

use Illuminate\Http\Request;

use App\Setting;

trait SettingsControllerTrait{

    public function permissions(Request $request)
    {

        if($this->getUser()->cannot('permissions', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access. This is only for system administrators.');
        }

        $this->validate($request, [
            'id' => 'required|max:255|validPermission',
            'checked' => 'required',
        ]);

        $admin = $this->loggedUserAdministrator();
        $attributes = $admin->getAttributes();

        $columnName = $request->id;
        $checkedValue = strtolower($request->checked);
        $checked = ($checkedValue  == 'true' || $checkedValue  == '1') ? true : false;

        //check whether the id they are sending us is a real permission
        if(isset($attributes[$columnName]))
        {
            $admin->$columnName = $checked;
            if($admin->save()){
                $checkedAfter = ($admin->$columnName) ? 'active' : 'inactive';
                return $this->respondWithSuccess('Permission has been changed to: '.$checkedAfter);
            }
            return $this->respondInternalError('Error while persisting the permission');
        }
        return $this->respondNotFound('There is no permission with that id');
    }

}
