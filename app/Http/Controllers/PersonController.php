<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\Person;

class PersonController extends Controller
{
    public function getAll(Request $req)
    {
        $page       = (int)$req->getQueryParam('page');
        $fname      = $req->getQueryParam('fname');
        $faction    = empty($req->getQueryParam('faction')) ? '5' : $req->getQueryParam('faction');
        $depart     = $req->getQueryParam('depart');
        $division   = $req->getQueryParam('division');

        $persons = Person::whereNotIn('person_state', [6,7,8,9,99])
                    ->join('level', 'personal.person_id', '=', 'level.person_id')
                    ->where('level.faction_id', $faction)
                    ->when($depart != '', function($q) use ($depart) {
                        $q->where('level.depart_id', $depart);
                    })
                    ->when($division != '', function($q) use ($division) {
                        $q->where('level.ward_id', $division);
                    })
                    ->when($fname != '', function($q) use ($fname) {
                        $q->where('person_firstname', 'like', '%'.$fname.'%');
                    })
                    ->with('prefix','position','academic')
                    ->with('memberOf','memberOf.depart')
                    ->paginate(10);

        return [
            'persons' => $persons
        ];
    }

    public function getById($id)
    {
        $person = Person::where('person_id', $id)
                    ->with('prefix','position')
                    ->first();
        
        return [
            'person' => $person
        ];
    }

    // public function store($request, $response, $args)
    // {
    //     try {
    //         $post = (array)$request->getParsedBody();

    //         $reg = new Registration;
    //         $reg->an = $post['an'];
    //         $reg->hn = $post['hn'];
    //         $reg->reg_date = $post['reg_date'];            
    //         $reg->reg_time = $post['reg_time'];
    //         $reg->ward = $post['ward'];
    //         $reg->bed = $post['bed'];
    //         $reg->code = $post['code'];
    //         $reg->lab_date = $post['lab_date'];
    //         $reg->lab_result = $post['lab_result'];
    //         $reg->dx = $post['dx'];
    //         $reg->symptom = $post['symptom'];
    //         $reg->reg_from = $post['reg_from'];
    //         $reg->reg_state = $post['reg_state'];
    //         $reg->remark = $post['remark'];

    //         if($reg->save()) {
    //             return $response
    //                     ->withStatus(200)
    //                     ->withHeader("Content-Type", "application/json")
    //                     ->write(json_encode([
    //                         'status' => 1,
    //                         'message' => 'Inserting successfully',
    //                         'reg' => $reg
    //                     ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //         } else {
    //             return $response
    //                 ->withStatus(500)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode([
    //                     'status' => 0,
    //                     'message' => 'Something went wrong!!'
    //                 ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //         }
    //     } catch (\Exception $ex) {
    //         return $response
    //                 ->withStatus(500)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode([
    //                     'status' => 0,
    //                     'message' => $ex->getMessage()
    //                 ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }

    // public function update($request, $response, $args)
    // {
    //     try {
    //         $post = (array)$request->getParsedBody();

    //         $reg = Registration::find($args['id']);
    //         /** get old bed for updating */
    //         $oldBed = $reg->bed;

    //         $reg->ward = $post['ward'];
    //         $reg->bed = $post['bed'];
    //         $reg->code = $post['code'];
    //         $reg->lab_date = $post['lab_date'];
    //         $reg->lab_result = $post['lab_result'];
    //         $reg->dx = $post['dx'];
    //         $reg->symptom = $post['symptom'];
    //         $reg->reg_from = $post['reg_from'];
    //         $reg->reg_state = $post['reg_state'];
    //         $reg->remark = $post['remark'];

    //         if($reg->save()) {
    //             /** if change bed do this */
    //             if($oldBed !== (int)$post['bed']) {
    //                 /** Update old bed */
    //                 Bed::where('bed_id', $oldBed)->update(['bed_status' => 0]);
    //                 /** Update new bed */
    //                 Bed::where('bed_id', $post['bed'])->update(['bed_status' => 1]);
    //             }

    //             return $response
    //                     ->withStatus(200)
    //                     ->withHeader("Content-Type", "application/json")
    //                     ->write(json_encode([
    //                         'status' => 1,
    //                         'message' => 'Updating successfully',
    //                         'reg' => $reg
    //                     ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //         } else {
    //             return $response
    //                 ->withStatus(500)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode([
    //                     'status' => 0,
    //                     'message' => 'Something went wrong!!'
    //                 ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //         }
    //     } catch (\Exception $ex) {
    //         return $response
    //                 ->withStatus(500)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode([
    //                     'status' => 0,
    //                     'message' => $ex->getMessage()
    //                 ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }

    // public function delete($request, $response, $args)
    // {
    //     try {
    //         if(Registration::where('book_id', $args['id'])->delete()) {
    //             return $response
    //                     ->withStatus(200)
    //                     ->withHeader("Content-Type", "application/json")
    //                     ->write(json_encode([
    //                         'status' => 1,
    //                         'message' => 'Deleting successfully',
    //                         'booking' => $booking
    //                     ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //         } else {
    //             return $response
    //                 ->withStatus(500)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode([
    //                     'status' => 0,
    //                     'message' => 'Something went wrong!!'
    //                 ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //         }
    //     } catch (\Exception $ex) {
    //         return $response
    //                 ->withStatus(500)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode([
    //                     'status' => 0,
    //                     'message' => $ex->getMessage()
    //                 ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }
}
