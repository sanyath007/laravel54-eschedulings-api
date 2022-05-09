<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\ShiftSwapping;

class ShiftSwappingController extends Controller
{
    public function getAll(Request $req)
    {
        $swappings = ShiftSwapping::with('owner','owner.person')
                        ->with('delegator','delegator.person')
                        ->paginate(10);

        return [
            'swappings' => $swappings
        ];
    }
    
    public function getById($id)
    {
        $shifts = ShiftSwapping::find($id);

        return [

        ];
    }

    public function store(Request $req)
    {
        
    }
}
