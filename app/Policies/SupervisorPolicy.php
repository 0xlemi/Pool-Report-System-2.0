<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class SupervisorPolicy
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
                return $session_user->userable()->admin()->sup_supervisor_index;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_supervisor_index;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_supervisor_index;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_supervisor_index;
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
                return $session_user->userable()->admin()->sup_supervisor_create;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_supervisor_create;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_supervisor_create;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_supervisor_create;
            }
        }
        return false;
    }

    public function show($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_supervisor_show;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_supervisor_show;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_supervisor_show;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_supervisor_show;
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
                return $session_user->userable()->admin()->sup_supervisor_edit;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_supervisor_edit;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_supervisor_edit;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_supervisor_edit;
            }
        }
        return false;
    }

    public function destroy($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_supervisor_destroy;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_supervisor_destroy;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_supervisor_destroy;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_supervisor_destroy;
            }
        }
        return false;
    }
}
