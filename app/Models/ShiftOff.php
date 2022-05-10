<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftOff extends Model
{
    protected $table = "shift_offs";

    public function schedule()
    {
        return $this->belongsTo(Scheduling::class, 'scheduling_id', 'id');
    }

    public function detail()
    {
        return $this->belongsTo(SchedulingDetail::class, 'scheduling_detail_id', 'id');
    }
}
