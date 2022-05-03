<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\Depart;
use App\Models\Person;

class DepartController extends Controller
{
    public function getAll(Request $req)
    {
        $departs = Depart::all();

        return [
            'departs' => $departs
        ];
    }
    
    public function getById($id)
    {
        $depart = Depart::where('depart_id', $id)->first();

        return [
            'depart' => $depart
        ];
    }

    public function getMemberOfDepart($depart)
    {
        $members = Person::join('level', 'level.person_id', '=', 'personal.person_id')
                    ->where(['level.depart_id' => $depart])
                    ->with('prefix','position')
                    ->where('person_state', '1')
                    ->get();

        return $members;
    }

    // public function store($request, $response, $args)
    // {
    //     $post = (array)$request->getParsedBody();

    //     $dept = new Unit;
    //     $dept->name = $post['depart_name'];
        
    //     if($dept->save()) {
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($dept, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }                    
    // }

    // public function update($request, $response, $args)
    // {
    //     $post = (array)$request->getParsedBody();

    //     $dept = Unit::where('depart_id', $args['id'])->first();
    //     $dept->name = $post['depart_name'];
        
    //     if($dept->save()) {
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($dept, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }

    // public function delete($request, $response, $args)
    // {
    //     $dept = Unit::where('depart_id', $args['id'])->first();
        
    //     if($dept->delete()) {    
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($dept, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }
}
