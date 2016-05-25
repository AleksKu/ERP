<?php

namespace Torg\Http\Controllers;

use Torg\Http\Requests;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       echo \Workspace::current()->account;

        return view('home');
    }
}
