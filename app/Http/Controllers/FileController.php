<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class FileController extends Controller
{
    public function getFile($id)
    {
        $path = public_path('uploads/10122021081424616543e0f0970.pdf');
        
        // return response()->file($path, [
        //     'Content-Disposition' => str_replace('%name', 'test.pdf', "inline; filename=\"%name\"; filename*=utf-8''%name"),
        //     'Content-Type'        => 'application/pdf', // e.g. 'application/pdf', 'text/plain' etc.
        // ]);
        return response()->download($path);
    }

    public function delete($path)
    {
        //
    }
}
