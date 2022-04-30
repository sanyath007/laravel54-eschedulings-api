<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Response;
use File;

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
}
