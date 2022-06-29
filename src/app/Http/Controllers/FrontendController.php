<?php

namespace App\Http\Controllers;


use Illuminate\View\View;

class FrontendController extends Controller
{
    /**
     * @return view
     */
    public function index() : view
    {
        return view('app');
    }
}
