<?php

namespace App\Http\Controllers\SaleMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SalePlan;
use App\Customer;
use App\SalePlanResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalePlanController extends Controller
{

    public function index()
    {
        $list_saleplan = DB::table('sale_plans')
            ->where('created_by', Auth::user()->id)
            ->orderby('id', 'desc')
            ->get();
        return view('saleplan.salePlan', compact('list_saleplan'));
    }

    // public function store(Request $request)
    // {
    //     // dd($request);
    //     SalePlan::create([
    //         'monthly_plan_id' => $request->id,
    //         'customer_shop_id' => $request->shop_id,
    //         'sale_plans_title' => $request->sale_plans_title,
    //         'sale_plans_date' => $request->sale_plans_date,
    //         'sale_plans_tags' => $request->sale_plans_tags,
    //         'sale_plans_objective' => $request->sale_plans_objective,
    //         'sale_plans_status' => 1,
    //         'created_by' => Auth::user()->id,
    //     ]);

    //     // echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='saleplan'; </script>");
    //     return back();
    // }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            SalePlan::create([
                'monthly_plan_id' => $request->id,
                'customer_shop_id' => $request->shop_id,
                'sale_plans_title' => $request->sale_plans_title,
                'sale_plans_date' => $request->sale_plans_date,
                'sale_plans_tags' => $request->sale_plans_tags,
                'sale_plans_objective' => $request->sale_plans_objective,
                'sale_plans_status' => 1,
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            //echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='lead'; </script>");

        } catch (\Exception $e) {

            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data' => $request,
        ]);
    }


    public function edit($id)
    {
        // $dataEdit = SalePlan::find($id);
        $dataEdit = SalePlan::join('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
            ->join('customer_contacts', 'customer_shops.id', '=', 'customer_contacts.customer_shop_id')
            ->where('sale_plans.id', $id)->select(
                'customer_contacts.customer_contact_name',
                'customer_contacts.customer_contact_phone',
                'customer_shops.shop_address',
                'customer_shops.id as shop_id',
                'customer_shops.shop_name',
                'sale_plans.id',
                'sale_plans.sale_plans_title',
                'sale_plans.sale_plans_date',
                'sale_plans.sale_plans_tags',
                'sale_plans.sale_plans_objective',
                'sale_plans.sale_plans_status'
            )->first();

        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
        SalePlan::find($request->id)->update([
            'customer_shop_id' => $request->shop_id,
            'sale_plans_title' => $request->sale_plans_title,
            'sale_plans_date' => $request->sale_plans_date,
            'sale_plans_tags' => $request->sale_plans_tags,
            'sale_plans_objective' => $request->sale_plans_objective,
            'sale_plans_status' => 1,
            'updated_by' => Auth::user()->id,
        ]);

        return back();
    }

    public function destroy($id)
    {
        SalePlan::where('id', $id)->delete();
        return back();
    }

    public function searchShop(Request $request)
    {
        if ($request->ajax()) {

            $data = Customer::where('shop_name', $request->search)->first();
        }
        return $data;
    }

    public function fetch_customer_shops_saleplan($id)
    {
        $result = DB::table('customer_shops')
            ->join('customer_contacts', 'customer_contacts.customer_shop_id', 'customer_shops.id')
            ->where('customer_shops.id', $id)
            ->select([
                'customer_contacts.*',
                'customer_shops.*'
            ])
            ->first();

        return response()->json($result);
    }

    public function saleplan_checkin(Request $request)
    {
        // dd($request);

        $chk_status = SalePlan::where('id', $request->id)->first();

        if ($chk_status->status_result == 1) {
            SalePlan::find($request->id)->update([
                'status_result' => 2,
            ]);

            $data2 = SalePlanResult::where('sale_plan_id', $request->id)->first();
            $data2->sale_plan_checkout_date   = Carbon::now();
            $data2->sale_plan_checkout_latitude   = $request->lat;
            $data2->sale_plan_checkout_longitude   = $request->lon;
            $data2->updated_by   = Auth::user()->id;
            $data2->updated_at   = Carbon::now();
            $data2->update();

            return back();
        }

        // SalePlan::find($request->id)->update([
        //     'status_result' => 1,
        // ]);

        // $data = new SalePlanResult;
        // $data->sale_plan_id   = $request->id;
        // $data->sale_plan_checkin_date   = Carbon::now();
        // $data->sale_plan_checkin_latitude   = $request->lat;
        // $data->sale_plan_checkin_longitude   = $request->lon;
        // $data->created_by   = Auth::user()->id;
        // $data->created_at   = Carbon::now();
        // $data->save();

        // // echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='saleplan'; </script>");
        // return back();
    }
}
