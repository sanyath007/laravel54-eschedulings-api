<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\ShiftOff;
use App\Models\SchedulingDetail;

class ShiftOffController extends Controller
{
    public function getAll(Request $req)
    {
        $offs = ShiftOff::with('schedule','schedule.depart','schedule.division')
                    ->with('detail','detail.person')
                    ->paginate(10);

        return [
            'offs' => $offs
        ];
    }
    
    public function getById($id)
    {
        $off = ShiftOff::find($id)
                        ->with('schedule','schedule.depart','schedule.division')
                        ->with('detail','detail.person');

        return [
            'off' => $off
        ];
    }

    public function store(Request $req)
    {
        //
    }
}
