<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return [
            'holidays'  => Holiday::all()
        ];
    }

    public function getHolidaysOfYear($year)
    {
        $holidays = Holiday::when(!empty($year), function($q) use ($year) {
            $sdate = ((int)$year - 544). '-10-01';
            $edate = ((int)$year - 543). '-09-30';

            $q->whereBetween('holiday_date', [$sdate, $edate]);
        })->get();

        return [
            'holidays' => $holidays,
        ];
    }
}
