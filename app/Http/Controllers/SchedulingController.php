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
use App\Models\Holiday;

class SchedulingController extends Controller
{
    public function getAll(Request $req)
    {
        $depart     = $req->get('depart');
        $division   = $req->get('division');
        $month      = $req->get('month');
        $sdate      = $month. '-01';
        $edate      = date('Y-m-t', strtotime($sdate));

        return [
            'schedulings'   => Scheduling::with('depart','division','controller')
                                ->with('controller.prefix','controller.position')
                                ->with('controller.academic')
                                ->with('shifts','shifts.person','shifts.person.prefix')
                                ->with('shifts.person.position','shifts.person.academic')
                                ->when($month != '', function($q) use ($month) {
                                    $q->where('month', $month);
                                })
                                ->get(),
            'memberOfDep'   => Person::join('level', 'level.person_id', '=', 'personal.person_id')
                                ->where([
                                    'level.faction_id'    => '5',
                                    'level.depart_id'     => $depart,
                                ])
                                ->where('person_state', '1')
                                ->get()
        ];
    }

    public function getById($id)
    {
        $scheduling = Scheduling::where('id', $id)
                        ->with('depart','division','controller')
                        ->with('shifts','shifts.person','shifts.person.prefix')
                        ->with('shifts.person.position','shifts.person.academic')
                        ->first();

        return [
            'scheduling'    => $scheduling
        ];
    }

    public function initForm()
    {
        return [
            'factions'      => Faction::all(),
            'departs'       => Depart::all(),
            'divisions'     => Division::all(),
            'shifts'        => Shift::all(),
            'holidays'      => Holiday::all(),
        ];
    }

    public function store(Request $req)
    {
        try {
            $scheduling = new Scheduling;
            $scheduling->depart_id      = $req['depart'];
            $scheduling->division_id    = $req['division'];
            $scheduling->month          = $req['month'];            
            $scheduling->year           = $req['year'];
            $scheduling->controller_id  = $req['controller'];
            $scheduling->total_persons  = $req['total_persons'];
            $scheduling->total_shifts   = $req['total_shifts'];
            $scheduling->remark         = $req['remark'];

            if($scheduling->save()) {
                $schedulingId = $scheduling->id;

                foreach($req['person_shifts'] as $ps) {
                    $shiftsText = implode(',', $ps['shifts']);

                    $detail = new SchedulingDetail;
                    $detail->scheduling_id  = $schedulingId;
                    $detail->person_id      = $ps['person']['person_id'];
                    $detail->shifts         = $shiftsText;
                    $detail->n              = $ps['n']; // เวรดึก
                    $detail->m              = $ps['m']; // เวรเช้า
                    $detail->e              = $ps['e']; // เวรบ่าย
                    $detail->b              = $ps['b']; // เวร BD
                    $detail->total          = $ps['total_shift'];
                    $detail->working        = 0;
                    $detail->ot             = 0;
                    $detail->save();
                }

                return [
                    'status' => 1,
                    'message' => 'Inserting successfully',
                    'scheduling' => $scheduling
                ];
            } else {
                return [
                    'status' => 0,
                    'message' => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status' => 0,
                'message' => $ex->getMessage()
            ];
        }
    }

    public function update(Request $req, $id)
    {
        try {
            $scheduling = Scheduling::find($id);
            $scheduling->depart_id      = $req['depart'];
            $scheduling->division_id    = $req['division'];
            $scheduling->month          = $req['month'];            
            $scheduling->year           = $req['year'];
            $scheduling->controller_id  = $req['controller'];
            $scheduling->total_persons  = $req['total_persons'];
            $scheduling->total_shifts   = $req['total_shifts'];
            $scheduling->remark         = $req['remark'];

            if($scheduling->save()) {
                /** TODO: To manipulate scheduling_detail data on scheduling is updated */
                $oldDetail = SchedulingDetail::where('scheduling_id', $id)->delete();

                foreach($req['person_shifts'] as $ps) {
                    $shiftsText = implode(',', $ps['shifts']);

                    $detail = new SchedulingDetail;
                    $detail->scheduling_id  = $id;
                    $detail->person_id      = $ps['person']['person_id'];
                    $detail->shifts         = $shiftsText;
                    $detail->n              = $ps['n']; // เวรดึก
                    $detail->m              = $ps['m']; // เวรเช้า
                    $detail->e              = $ps['e']; // เวรบ่าย
                    $detail->b              = $ps['b']; // เวร BD
                    $detail->total          = $ps['total'];
                    $detail->working        = 0;
                    $detail->ot             = 0;
                    $detail->save();
                }

                return [
                    'status' => 1,
                    'message' => 'Updating successfully',
                    'scheduling' => $scheduling
                ];
            } else {
                return [
                    'status' => 0,
                    'message' => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status' => 0,
                'message' => $ex->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $scheduling = Scheduling::find($id);

            if($scheduling->delete()) {
                /** TODO: To manipulate scheduling_detail data on scheduling is deleted */
                $deletedDetail = SchedulingDetail::where('scheduling_id', $id)->delete();

                return [
                    'status'    => 1,
                    'message'   => 'Deleting successfully',
                    'id'        => $id
                ];
            } else {
                return [
                    'status' => 0,
                    'message' => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status' => 0,
                'message' => $ex->getMessage()
            ];
        }
    }
}
