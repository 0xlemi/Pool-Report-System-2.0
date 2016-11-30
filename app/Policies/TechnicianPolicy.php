<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class TechnicianPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Administrator has all permissions
     */
    public function before($type)
    {
        if($type->isAdministrator()){
            return true;
        }
    }


    public function index($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_technician_index;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_technician_index;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_technician_index;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_technician_index;
            }
        }
        return false;
    }

    public function create($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_technician_create;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_technician_create;
            }
        }elseif($type->isTechnician()){
            return false;    
        }
        return false;
    }

    public function show($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_technician_show;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_technician_show;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_technician_show;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_technician_show;
            }
        }
        return false;
    }

    public function edit($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_technician_edit;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_technician_edit;
            }
        }elseif($type->isTechnician()){
            return false;
        }
        return false;
    }

    public function destroy($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_technician_destroy;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_technician_destroy;
            }
        }elseif($type->isTechnician()){
            return false;
        }
        return false;
    }
}
