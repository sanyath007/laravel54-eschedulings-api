<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftSwapping extends Model
{
    protected $table = "shift_swappings";

    public function schedule()
    {
        return $this->belongsTo(Scheduling::class, 'scheduling_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(SchedulingDetail::class, 'owner_detail_id', 'id');
    }

    public function delegator()
    {
        return $this->belongsTo(SchedulingDetail::class, 'delegator_detail_id', 'id');
    }
}