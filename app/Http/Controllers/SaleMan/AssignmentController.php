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

    public function assignment_result_get($id)
    {
        $dataResult = Assignment::where('id', $id)->first();
        $emp_approve = DB::table('users')
        ->where('id', $dataResult->assign_approve_id)
        ->first();
        $data = array(
            'dataResult'     => $dataResult,
            'emp_approve'    => $emp_approve,
        );
        echo json_encode($data);

    }

    public function saleplan_result(Request $request)
    { // สรุปผลลัพธ์
        // dd($request);
        Assignment::find($request->assign_id)->update([
            // 'assign_result_detail' => $request->assign_detail,
            'assign_result_status' => $request->assign_result,
            'updated_by' => Auth::user()->id,
        ]);

        return back();
    }

    public function search_month_assignment(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $assignments = Assignment::where('assign_emp_id', Auth::user()->id)
        ->where('assign_status', 3)
        ->whereDate('assign_work_date', '>=', $from)
        ->whereDate('assign_work_date', '<=', $to)
        ->orderBy('id', 'desc')->get();

        // return $assignments;
        // dd($request, $assignments); 
        return view('saleman.assignment', compact('assignments'));
    }
}
