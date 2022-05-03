<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\Scheduling;
use App\Models\SchedulingDetail;
use App\Models\Person;
use App\Models\Faction;
use App\Models\Depart;
use App\Models\Division;
use App\Models\MemberOf;
use App\Models\Shift;
use App\Models\ShiftSwapping;
use App\Models\Holiday;

class SchedulingDetailController extends Controller
{
    public function getAll($scheduleId)
    {
        return [
            'details'   => SchedulingDetail::with('person')
                            ->with('person.prefix','person.position')
                            ->with('scheduling','scheduling.division','scheduling.depart')
                            ->with('scheduling.controller')
                            ->where('scheduling_id', $scheduleId)
                            ->get()
        ];
    }

    public function getById($id)
    {
        $detail = SchedulingDetail::where('id', $id)
                        ->with('person')
                        ->with('person.prefix','person.position')
                        ->with('scheduling','scheduling.division','scheduling.depart')
                        ->with('scheduling.controller')
                        ->first();

        return [
            'detail'    => $detail
        ];
    }

    public function update(Request $req, $id)
    {
        try {
            $post = (array)$req->getParsedBody();

            $detail = SchedulingDetail::find($id);
            $detail->scheduling_id  = $post['scheduling_id'];
            $detail->person_id      = $post['person_id'];
            $detail->shifts         = $post['shifts'];

            if($detail->save()) {
                /** 
                 * To manipulate total_persons and total_shifts of schedulings data 
                 * on scheduling_detail is updated 
                */
                // $scheduling = Scheduling::find($post['scheduling_id']);
                // $scheduling->total_persons  = $post['total_persons'];
                // $scheduling->total_shifts   = $post['total_shifts'];
                // $scheduling->save();

                return [
                    'status'    => 1,
                    'message'   => 'Updating successfully',
                    'detail'    => $detail
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

    public function oT(Request $req)
    {
        try {
            $shiftsText = implode(',', $req['ot_shifts']);

            $detail = SchedulingDetail::find($args['id']);
            $detail->working        = $req['working'];
            $detail->ot_shifts      = $shiftsText;
            $detail->ot             = $req['ot'];

            if($detail->save()) {
                return [
                    'status'    => 1,
                    'message'   => 'Updating successfully',
                    'detail'    => $detail
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

    public function delete($req, $res, $args)
    {
        try {
            $scheduling = Scheduling::find($args['id']);

            if($scheduling->delete()) {
                /** TODO: To manipulate scheduling_detail data on scheduling is deleted */
                $deletedDetail = SchedulingDetail::where('scheduling_id', $args['id'])->delete();

                return [
                    'status'    => 1,
                    'message'   => 'Deleting successfully',
                    'id'        => $id
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

    public function swap($req, $res, $args)
    {
        try {
            $post = (array)$req->getParsedBody();

            /** To add new ShiftSwapping record */
            $swap = new ShiftSwapping;
            $swap->owner_detail_id  = $args['id'];              // รหัสเวรที่จะขอเปลี่ยน
            $swap->owner_date       = $post['owner_date'];      // วันที่จะขอเปลี่ยน
            $swap->owner_shift      = $post['owner_shift'];     // เวรที่จะขอเปลี่ยน
            $swap->reason           = $post['reason'];
            $swap->delegator        = $post['delegator'];       // ผู้ปฏิบัติงานแทน
            $swap->have_swap        = $post['have_swap'];

            $swap->swap_detail_id   = $post['swap_detail_id'];  // รหัสเวรที่จะปฏิบัติงานแทน
            $swap->swap_date        = $post['swap_date'];       // วันที่จะปฏิบัติงานแทน
            $swap->swap_shift       = $post['swap_shift'];      // เวรที่จะปฏิบัติงานแทน
            $swap->status           = 'REQUESTED';

            if($swap->save()) {
                /** Update owner's shift */
                $owner = SchedulingDetail::find($args['id']);
                $owner->shifts = $post['owner_shifts'];
                $owner->save();

                /** Update delegator's shift */
                $delegator = SchedulingDetail::find($post['swap_detail_id']);
                $delegator->shifts = $post['delegator_shifts'];
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

    public function off(Request $req, $id)
    {
        try {
            /** To add new ShiftOff record */
            $off = new ShiftOff;
            $off->scheduling_detail_id = $id;
            $off->reason = $req['reason'];
            $off->status = 'APPROVED';

            if($off->save()) {
                $shiftsText = implode(',', $req['shifts']);
                /** Update scheduling_details data */
                $owner = SchedulingDetail::find($id);
                $detail->shifts         = $shiftsText;
                $detail->n              = $req['n']; // เวรดึก
                $detail->m              = $req['m']; // เวรเช้า
                $detail->e              = $req['e']; // เวรบ่าย
                $detail->b              = $req['b']; // เวร BD
                $detail->total          = $req['total'];
                $owner->save();

                /** Update total shifts of schedulings */
                $delegator = Scheduling::find($swap->swap_detail_id);
                $delegator->shifts = $post['delegator_shifts'];
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
