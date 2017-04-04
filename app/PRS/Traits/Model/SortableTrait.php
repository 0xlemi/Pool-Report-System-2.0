<?php

namespace App\PRS\Traits\Model;

use Illuminate\Database\Eloquent\Collection;

trait SortableTrait
{

    public function scopeSeqIdOrdered($query, $order = 'asc')
    {
        return $query->orderBy('seq_id', $order);
    }

    public function scopeLastToFirst()
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeFirstToLast($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

}
