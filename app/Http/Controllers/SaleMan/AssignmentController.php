<?php

namespace App\Http\Controllers\SaleMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Assignment;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignments = Assignment::where('assign_emp_id', Auth::user()->id)
        ->where('assign_status', 3)
        ->orderBy('id', 'desc')
        ->get();

        return view('saleman.assignment', compact('assignments'));
    }

    public function search_month_assignment(Request $request)
    {
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $assignments = Assignment::where('assign_emp_id', Auth::user()->id)
        ->where('assign_status', 3)
        ->whereDate('assign_work_date', '>=', $from)
        ->whereDate('assign_work_date', '<=', $to)
        ->orderBy('id', 'desc')->get();

        return view('saleman.assignment', compact('assignments'));
    }
    
}
