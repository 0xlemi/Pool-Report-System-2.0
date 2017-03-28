<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;
use App\Administrator;
use App\PRS\Traits\Model\ImageTrait;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Technician extends Model
{

    use ImageTrait;

    // not using timestamps because trows a bug when you try to run
    // $admin->setTechniciansAsInactive() updated_at field is
    public $timestamps = false;

    /**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
		'name',
        'last_name',
        'cellphone',
        'address',
        'language',
        'comments',
	];


	/**
	 * assaciated reports with this technician
	 * tested
	 */
    public function reports(){
    	return $this->hasMany('App\Report');
    }

    /**
     * Associated administrator with this technician
     * tested
     */
    public function admin(){
    	$admin_id = Supervisor::findOrFail($this->supervisor_id)->admin_id;
    	return Administrator::findOrFail($admin_id);
    }

}
