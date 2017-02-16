<?php

namespace App\PRS\ValueObjects\Administrator;
use App\Administrator;


class Permissions {


    protected $permissions;

    public function __construct(Administrator $admin)
    {
        $this->permissions = $this->buildPermissions($admin);
    }

    public function getAll()
    {
        return $this->permissions;    
    }

    /**
     * Get the permissions that consern the supervisor role
     * @param  string $object permission over what object
     * @return array         array of objects
     * tested
     */
    public function supervisor($object = null)
    {
        return $this->filterPermissions('sup', $object);
    }

    /**
     * Get the permissions that consern the technician role
     * @param  string $object permission over what object
     * @return array         array of objects
     * tested
     */
    public function technician($object = null)
    {
        return $this->filterPermissions('tech', $object);
    }

    /**
     * Filter Permission depending on the name
     * @param  string $user   the role that has the permission
     * @param  string $object the object in which the acction is made
     * @return array
     */
    protected function filterPermissions($user, $object)
    {
        $result = [];
        foreach ($this->permissions as $value) {
            $explode =explode('_', $value->name);
            // check the user
            if($explode[0] == $user){
                if($object){
                    // if Object is set return permissions that relate to the object
                    if($object == $explode[1]){
                        $result[] = $value;
                    }
                // if Object is null return all
                }else{
                    $result[] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * Get all the permissions devided into sections
     * @param  string $user   the role that has the permission
     * @return array
     */
    public function permissionsDivided($user)
    {
        return [
            'report' => $this->filterPermissions($user, 'report'),
            'workorder' => [
                            'this' => $this->filterPermissions($user, 'workorder'),
                            'work' => $this->filterPermissions($user, 'work')
                        ],
            'service' => [
                            'this' => $this->filterPermissions($user, 'service'),
                            'contract' =>  $this->filterPermissions($user, 'contract'),
                            'chemical' => $this->filterPermissions($user, 'chemical'),
                            'equipment' => $this->filterPermissions($user, 'equipment')
                        ],
            'client' => $this->filterPermissions($user, 'client'),
            'supervisor' => $this->filterPermissions($user, 'supervisor'),
            'technician' => $this->filterPermissions($user, 'technician'),
            'invoice' => [
                            'this' => $this->filterPermissions($user, 'invoice'),
                            'payments' => $this->filterPermissions($user, 'payment')
                        ],
        ];
    }

    // Get all the premissions and tags for the admin
    protected function buildPermissions(Administrator $admin)
    {
        $permissions = config('constants.permissions');
        $result = [];
        foreach ($permissions as $name => $tag) {
            $result[] = (object)[ 'tag' => $tag , 'checked' => $admin->$name, 'name' => $name];
        }
        return $result;
    }

}
