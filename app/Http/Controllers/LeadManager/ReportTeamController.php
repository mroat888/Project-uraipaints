<?php

namespace App\Http\Controllers\LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportTeamController extends Controller
{
    public function index(){
        $data['users'] = DB::table('users')->where('team_id',Auth::user()->team_id)->get();
        return view('reports.report_team', $data);
    }
}
