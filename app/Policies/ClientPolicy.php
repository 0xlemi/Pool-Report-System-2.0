<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class ClientPolicy
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

    // tested (api)
    public function index($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_client_index;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_client_index;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_client_index;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_client_index;
            }
        }
        return false;
    }

    // tested (api)
    public function create($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_client_create;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_client_create;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_client_create;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_client_create;
            }
        }
        return false;
    }

    // tested (api)
    public function show($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_client_show;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_client_show;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_client_show;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_client_show;
            }
        }
        return false;
    }

    // tested (api)
    public function edit($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_client_edit;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_client_edit;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_client_edit;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_client_edit;
            }
        }
        return false;
    }

    // tested (api)
    public function destroy($type)
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if($type->isSupervisor()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->sup_client_destroy;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->sup_client_destroy;
            }
        }elseif($type->isTechnician()){
            if(isset($session_user)){
                return $session_user->userable()->admin()->tech_client_destroy;
            }elseif(isset($api_user)){
                return $api_user->userable()->admin()->tech_client_destroy;
            }
        }
        return false;
    }
}
