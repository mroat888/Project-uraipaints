<?php

namespace App\Http\Controllers\LeadManager;

use App\Assignment;
use App\AssignmentComment;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use App\SalePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalSalePlanController extends Controller
{

    public function index()
    {
        // $data['list_saleplan'] = DB::table('sale_plans')
        // ->leftjoin('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
        // ->leftjoin('users', 'sale_plans.created_by', '=', 'users.id')
        // ->leftjoin('sale_plan_results', 'sale_plans.id', '=', 'sale_plan_results.sale_plan_id')
        // ->where('sale_plans.sale_plans_status', 1)
        //     ->select(
        //         'users.name',
        //         'sale_plan_results.sale_plan_status',
        //         'customer_shops.shop_name',
        //         'customer_shops.shop_saleplan_date',
        //         'sale_plans.*'
        //     )
        //     // ->where('sale_plans.created_by', Auth::user()->id)
        //     ->orderBy('id', 'desc')->get();

        $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
            ->where('status_approve', 1)->select('users.name', 'monthly_plans.*')->get();

        return view('leadManager.approval_saleplan', $data);
    }

    public function approvalsaleplan_detail($id)
    {
        $data['list_saleplan'] = DB::table('sale_plans')
            ->leftjoin('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
            ->leftjoin('users', 'sale_plans.created_by', '=', 'users.id')
            ->leftjoin('sale_plan_results', 'sale_plans.id', '=', 'sale_plan_results.sale_plan_id')
            ->where('sale_plans.sale_plans_status', 1)
            ->where('sale_plans.monthly_plan_id', $id)
            ->select(
                'users.name',
                'sale_plan_results.sale_plan_status',
                'customer_shops.shop_name',
                'customer_shops.shop_saleplan_date',
                'sale_plans.*'
            )
            ->orderBy('id', 'desc')->get();

        return view('leadManager.approval_saleplan_detail', $data);
    }

    public function comment_saleplan($id)
    {
        $dataEdit = SalePlan::where('id', $id)->first();
        $dataEdit2 = AssignmentComment::where('assign_id', $id)->first();

        $data = array(
            'dataEdit'     => $dataEdit,
            'dataEdit2'     => $dataEdit2,
        );
        echo json_encode($data);
    }

    public function create_comment_saleplan(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {

            $data = AssignmentComment::where('assign_id', $request->id)->first();

            if ($data) {
                AssignmentComment::where('assign_id', $request->id)->update([
                    'assign_comment_detail' => $request->comment,
                    'updated_by' => Auth::user()->id,
                ]);
                DB::commit();
            } else {
                AssignmentComment::create([
                    'assign_id' => $request->id,
                    'assign_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                ]);
                DB::commit();
            }
        } catch (\Exception $e) {

            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data' => $request,
        ]);
    }

    public function approval_saleplan_confirm(Request $request)
    {
        dd($request);

        if ($request->checkapprove) {
            $data = SalePlan::get();
            if ($request->CheckAll == "Y") {
                foreach ($data as $value) {
                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('id', $chk)->update([
                            'sale_plans_status' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }
            } else {
                foreach ($data as $value) {
                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('id', $chk)->update([
                            'sale_plans_status' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }
            }
        } else {
            return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
        }

        return back();
    }
}
