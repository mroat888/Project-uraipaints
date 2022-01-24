<?php

namespace App\Http\Controllers\SaleMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Assignment;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignments = Assignment::where('assign_emp_id', Auth::user()->id)->where('assign_status', "NULL")->orderBy('id', 'desc')->get();
        return view('saleman.assignment', compact('assignments'));
    }

    public function assignment_result_get($id)
    {
        $dataResult = Assignment::where('id', $id)->first();


    $data = array(
        'dataResult'     => $dataResult,
    );
    echo json_encode($data);

    }

    public function saleplan_result(Request $request)
    { // สรุปผลลัพธ์
        // dd($request);
        Assignment::find($request->assign_id)->update([
            'assign_result_detail' => $request->assign_detail,
            'assign_result_status' => $request->assign_result,
            'updated_by' => Auth::user()->id,
        ]);

        return back();
    }
}
