<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\Division;
use App\Models\Person;

class DivisionController extends Controller
{
    public function getAll(Request $req)
    {
        $dept = Division::all();

        return [
            'divisions' => $divisions
        ];
    }
    
    public function getById($id)
    {
        $dept = Division::where('ward_id', $id)->first();

        return [
            'division' => $division
        ];
    }

    public function getMemberOfDivision($division)
    {
        $members = Person::join('level', 'level.person_id', '=', 'personal.person_id')
                    ->where(['level.ward_id' => $division])
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
