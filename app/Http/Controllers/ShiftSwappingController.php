<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\ShiftSwapping;
use App\Models\SchedulingDetail;

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
        $swapping = ShiftSwapping::find($id)
                        ->with('owner','owner.person')
                        ->with('delegator','delegator.person');

        return [
            'swapping' => $swapping
        ];
    }

    public function store(Request $req)
    {
        //
    }

    /**
     * การอนุมัติการขอเปลี่ยน/สลับ/ขายเวร (เฉพาะหัวหน้า)
     */
    public function approve(Request $req, $id)
    {
        try {
            $swap = ShiftSwapping::find($id);
            $swap->status = 'APPROVED';
    
            if($swap->save()) {
                /** Update owner's shift */
                $ownerShiftsText = implode(',', $req['owner_shifts']['shifts']);

                $owner = SchedulingDetail::find($swap->owner_detail_id);
                $owner->shifts  = $ownerShiftsText;
                $owner->n       = $req['owner_shifts']['n']; // เวรดึก
                $owner->m       = $req['owner_shifts']['m']; // เวรเช้า
                $owner->e       = $req['owner_shifts']['e']; // เวรบ่าย
                $owner->b       = $req['owner_shifts']['b']; // เวร BD
                $owner->total   = $req['owner_shifts']['total'];
                $owner->save();

                /** Update delegator's shift */
                $delegatorShiftsText = implode(',', $req['delegator_shifts']['shifts']);

                $delegator = SchedulingDetail::find($swap->delegator_detail_id);
                $delegator->shifts  = $delegatorShiftsText;
                $delegator->n       = $req['delegator_shifts']['n']; // เวรดึก
                $delegator->m       = $req['delegator_shifts']['m']; // เวรเช้า
                $delegator->e       = $req['delegator_shifts']['e']; // เวรบ่าย
                $delegator->b       = $req['delegator_shifts']['b']; // เวร BD
                $delegator->total   = $req['delegator_shifts']['total'];
                $delegator->save();

                return [
                    'status'    => 1,
                    'message'   => 'Updating successfully',
                ];
            } else {
                return [
                    'status'    => 0,
                    'message'   => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status'    => 0,
                'message'   => $ex->getMessage()
            ];
        }
    }
}
