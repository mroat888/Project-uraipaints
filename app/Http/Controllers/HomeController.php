<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->status == 1) {
            return view('dashboard');
        }elseif (Auth::user()->status == 2) {
            return view('leadManager');
        }elseif (Auth::user()->status == 3) {
            return view('headManage');
        }elseif (Auth::user()->status == 4) {
            return view('admin');
        }

    }
}
