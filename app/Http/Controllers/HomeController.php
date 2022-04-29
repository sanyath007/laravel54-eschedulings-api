<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return [
            'page' => 'Home page',
            'body' => 'This is Home page.'
        ];
    }
}
