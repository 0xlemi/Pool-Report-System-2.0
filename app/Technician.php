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
        'supervisor_id',
	];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
	];

    /**
     * Get the user that this technician morphs to
     * @return $User
     * tested
     */
    public function user()
    {
      return $this->morphOne('App\User', 'userable')->first();
    }

	/**
	 * associated supervisor with this technician
	 * tested
	 */
    public function supervisor(){
    	return $this->belongsTo('App\Supervisor')->first();
    }

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
