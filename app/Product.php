<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use App\GlobalProduct;

class Product extends Model
{
    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'amount',
        'global_product_id'
    ];

    // *******************
    //    Relationships
    // *******************

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function globalProduct()
    {
        return $this->belongsTo(GlobalProduct::class);
    }

}
