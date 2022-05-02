<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Response;
use File;
use App\Models\Scheduling;
use App\Models\SchedulingDetail;
use App\Models\Person;

class FileController extends Controller
{
    public function getFile($file)
    {
        $path = storage_path('app/public/10122021081424616543e0f0970.pdf');

        return response()->file($path, [
            'Content-Type'        => 'application/pdf', // e.g. 'application/pdf', 'text/plain' etc.
            'Content-Disposition' => "inline; filename=test.pdf;",
        ]);

        return Response::download($path, 'test.pdf', ['Content-Type' => 'application/pdf']);
    }

    public function saveFile()
    {
        $file = File::get(public_path('uploads/10122021081424616543e0f0970.pdf'));

        Storage::disk('public')->put('10122021081424616543e0f0970.pdf', $file);

        return storage_path('app/public/10122021081424616543e0f0970.pdf');
    }

    public function delete($file)
    {
        //
    }

    public function printForm($id)
    {
        $schedule = Scheduling::where('id', $id)
                        ->with('depart','division','controller')
                        ->with('depart.faction')
                        ->with('shifts','shifts.person')
                        ->with('shifts.person.prefix','shifts.person.position')
                        ->first();

        $controller = Person::where('person_id', $schedule->controller_id)
                        ->with('prefix','position')
                        ->first();

        $headOfFaction = Person::join('level', 'personal.person_id', '=', 'level.person_id')
                            ->where('level.faction_id', $schedule->depart->faction_id)
                            ->where('level.duty_id', '1')
                            ->with('prefix','position')
                            ->first();

        $data = [
            'schedule' => $schedule,
            'controller' => $controller,
            'headOfFaction' => $headOfFaction,
        ];

        $paper = ['size' => 'legal', 'orientation' => 'landscape'];
        /** Invoke helper function to return view of pdf instead of laravel's view to client */
        return renderPdf('forms.form01', $data, $paper); // if you need to save file set 4th arg as 'download'
    }
}
