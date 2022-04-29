<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\Shift;

class ShiftController extends Controller
{
    public function getAll(Request $req)
    {
        $shifts = Shift::all();

        return [
            'shifts' => $shifts
        ];
    }

    public function getById($id)
    {
        $shift = Shift::find($id);
                    
        return [
            'shift' => $shift
        ];
    }

    public function getByName($name)
    {
        $shift = Shift::where('name', $name);
                    
        return [
            'shift' => $shift
        ];
    }
}
