<?php

namespace App\Http\Controllers\LeadManager;

use App\Assignment;
use App\AssignmentComment;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use App\SalePlan;
use App\SaleplanComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalSalePlanController extends Controller
{

    public function index()
    {

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

    // public function comment_saleplan($id)
    // {
    //     $dataEdit = SalePlan::where('id', $id)->first();
    //     $dataEdit2 = AssignmentComment::where('assign_id', $id)->first();

    //     $data = array(
    //         'dataEdit'     => $dataEdit,
    //         'dataEdit2'     => $dataEdit2,
    //     );
    //     echo json_encode($data);
    // }

    // public function create_comment_saleplan(Request $request)
    // {
    //     // return $request;
    //     DB::beginTransaction();
    //     try {

    //         $data = AssignmentComment::where('assign_id', $request->id)->first();

    //         if ($data) {
    //             AssignmentComment::where('assign_id', $request->id)->update([
    //                 'assign_comment_detail' => $request->comment,
    //                 'updated_by' => Auth::user()->id,
    //             ]);
    //             DB::commit();
    //         } else {
    //             AssignmentComment::create([
    //                 'assign_id' => $request->id,
    //                 'assign_comment_detail' => $request->comment,
    //                 'created_by' => Auth::user()->id,
    //             ]);
    //             DB::commit();
    //         }
    //     } catch (\Exception $e) {

    //         DB::rollback();
    //     }

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'บันทึกข้อมูลสำเร็จ',
    //         'data' => $request,
    //     ]);
    // }

    public function comment_saleplan($id, $createID)
    {
        // return $id;

            $data['data'] = SaleplanComment::where('saleplan_id', $id)->first();
            $data['saleplanID'] = $id;
            $data['createID'] = $createID;
            // return $data;
            if ($data) {
                return view('leadManager.create_comment_saleplan', $data);
            }else {
                return view('leadManager.create_comment_saleplan', $data);
            }
    }

    public function create_comment_saleplan(Request $request)
    {
        // dd($request);
            $data = SaleplanComment::where('saleplan_id', $request->id)->first();
            // return $request->id;
            if ($data) {
               $dataEdit = SaleplanComment::where('saleplan_id', $request->id)->update([
                    'saleplan_comment_detail' => $request->comment,
                    'updated_by' => Auth::user()->id,
                ]);
                return redirect(url('approvalsaleplan_detail', $request->createID));

            } else {
                SaleplanComment::create([
                    'saleplan_id' => $request->id,
                    'saleplan_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                ]);
                return redirect(url('approvalsaleplan_detail', $request->createID));
            }

    }

    public function approval_saleplan_confirm_all(Request $request)
    {
        // dd($request);

        if ($request->checkapprove) {
            if ($request->approve) {
            if ($request->CheckAll == "Y") {

                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('monthly_plan_id', $chk)->update([
                            'sale_plans_status' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
            } else {
                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('monthly_plan_id', $chk)->update([
                            'sale_plans_status' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
            }

        }else {
            if ($request->CheckAll == "Y") {
                // return "yy";
                foreach ($request->checkapprove as $key => $chk) {
                    SalePlan::where('monthly_plan_id', $chk)->update([
                        'sale_plans_status' => 3,
                        'updated_by' => Auth::user()->id,
                    ]);
                    MonthlyPlan::where('id', $chk)->update([
                        'status_approve' => 3,
                        'updated_by' => Auth::user()->id,
                    ]);
                }
                return back();
            } else {
                foreach ($request->checkapprove as $key => $chk) {
                    SalePlan::where('monthly_plan_id', $chk)->update([
                        'sale_plans_status' => 3,
                        'updated_by' => Auth::user()->id,
                    ]);
                    MonthlyPlan::where('id', $chk)->update([
                        'status_approve' => 3,
                        'updated_by' => Auth::user()->id,
                    ]);
                }
                // return back();
            }
    }

        } else {
            return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
        }

        return back();
    }

    public function approval_saleplan_confirm(Request $request)
    {
        // dd($request);

        if ($request->checkapprove) {
            if ($request->approve) {
            if ($request->CheckAll == "Y") {
                // return "yy";
                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('id', $chk)->update([
                            'sale_plans_status' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);

                        // MonthlyPlan::where('id', $chk)->update([
                        //     'status_approve' => 2,
                        //     'updated_by' => Auth::user()->id,
                        // ]);
                    }
            } else {
                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('id', $chk)->update([
                            'sale_plans_status' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
            }
        }else {
                if ($request->CheckAll == "Y") {
                    // return "yy";
                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('id', $chk)->update([
                                'sale_plans_status' => 3,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    return back();
                } else {
                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('id', $chk)->update([
                                'sale_plans_status' => 3,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    return back();
                }
        }
        } else {
            return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
        }

        return back();
    }
}
