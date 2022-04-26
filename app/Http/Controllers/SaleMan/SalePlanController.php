<?php

namespace App\Http\Controllers\SaleMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SalePlan;
use App\Customer;
use App\SalePlanResult;
use App\MonthlyPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;
use App\MasterPresentSaleplan;

class SalePlanController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $list_saleplan = DB::table('sale_plans')
            ->where('created_by', Auth::user()->id)
            ->orderby('id', 'desc')->get();
        return view('saleplan.salePlan', compact('list_saleplan'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

            DB::table('sale_plans')
            ->insert([
                'monthly_plan_id' => $monthly_plan->id,
                'customer_shop_id' => $request->shop_id,
                'sale_plans_title' => $request->sale_plans_title,
                'sale_plans_date' => Carbon::now()->addMonth(1),
                'sale_plans_tags' => implode( ',', $request->sale_plans_tags),
                'sale_plans_objective' => $request->sale_plans_objective,
                'sale_plans_status' => 0,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('monthly_plans')->where('id', $monthly_plan->id)
            ->update([
                'sale_plan_amount' => $monthly_plan->sale_plan_amount+1,
                'total_plan' => $monthly_plan->total_plan+1,
                'outstanding_plan' => ($monthly_plan->total_plan + 1) - $monthly_plan->success_plan,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }


    public function edit($id)
    {
        $dataEdit = SalePlan::find($id);

        $dataEdit = SalePlan::join('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
            ->join('customer_contacts', 'customer_shops.id', '=', 'customer_contacts.customer_shop_id')
            ->join('master_present_saleplan', 'sale_plans.sale_plans_tags', '=', 'master_present_saleplan.id')
            ->where('sale_plans.id', $id)->select(
                'master_present_saleplan.present_title',
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

    public function edit_fetch(Request $request)
    {
        $saleplan = DB::table('sale_plans')
        ->where('sale_plans.id', $request->id)
        ->select(
            'sale_plans.id',
            'sale_plans.customer_shop_id',
            'sale_plans.sale_plans_title',
            'sale_plans.sale_plans_date',
            'sale_plans.sale_plans_tags',
            'sale_plans.sale_plans_objective',
            'sale_plans.sale_plans_status'
        )->first();

        // ------ API
        $api_token = $this->api_token->apiToken();

        $path_search = "sellers/".Auth::user()->api_identify."/customers";
        $response = Http::withToken($request->api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            if($value['identify'] == $saleplan->customer_shop_id){
                $shop_address   = $value['address1']." ".$value['adrress2'];
                $shop_phone     = $value['telephone'];
                $shop_mobile    = $value['mobile'];
            }
            $customer_api[$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
            ];
        }
        // -----  END API

        $master_present = MasterPresentSaleplan::orderBy('id', 'desc')->get();

        // -----  API สินค้านำเสนอ----------- //
        $path_search = "pdglists?sortorder=DESC";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $pdglists_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $pdglists_api[$key] =
            [
                'identify' => $value['identify'],
                'name' => $value['name'],
                'sub_code' => $value['sub_code'],
            ];
        }


        return response()->json([
            'status' => 200,
            'salepaln' => $saleplan,
            'customer_api' => $customer_api,
            'shop_address' => $shop_address,
            'shop_phone' => $shop_phone,
            'shop_mobile' => $shop_mobile,
            'master_present' => $master_present,
            'pdglists_api' => $pdglists_api,
        ]);
    }

    public function update(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            SalePlan::find($request->id)->update([
                'customer_shop_id' => $request->shop_id,
                'sale_plans_title' => $request->sale_plans_title,
                'sale_plans_date' => $request->sale_plans_date,
                // 'sale_plans_tags' => $request->sale_plans_tags,
                'sale_plans_tags' => implode( ',', $request->sale_plans_tags),
                'sale_plans_objective' => $request->sale_plans_objective,
                'sale_plans_status' => 0,
                'updated_by' => Auth::user()->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);

        }

    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('sale_plans')
                ->where('id', $request->saleplan_id_delete)->delete();

                $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

                DB::table('monthly_plans')->where('id', $monthly_plan->id)
                ->update([
                    'sale_plan_amount' => $monthly_plan->sale_plan_amount-1,
                    'total_plan' => $monthly_plan->total_plan-1,
                    'outstanding_plan' => $monthly_plan->total_plan-1,
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลลูกค้าเรียบร้อยแล้ว',
        ]);
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
        // -----  API
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/customers/'.$id);
        $res_api = $response->json();

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['address1']." ".$value['adrress2'],
                'shop_phone' => $value['telephone'],
                'shop_mobile' => $value['mobile'],
            ];
        }

        return response()->json($customer_api);
    }

    public function saleplan_checkin(Request $request)
    { // เช็คอิน-เช็คเอ้าท์
        // dd($request);

        $chk_status = SalePlan::where('id', $request->id)->first();

            if ($chk_status->status_result == 0) {

                DB::beginTransaction();
                try {

                    if($request->lat != "" && $request->lon != ""){

                        SalePlan::find($request->id)->update([
                            'status_result' => 1,
                        ]);

                        $data2 = new SalePlanResult;
                        $data2->sale_plan_id = $request->id;
                        $data2->sale_plan_checkin_date   = Carbon::now();
                        $data2->sale_plan_checkin_latitude   = $request->lat;
                        $data2->sale_plan_checkin_longitude   = $request->lon;
                        $data2->created_by   = Auth::user()->id;
                        $data2->created_at   = Carbon::now();
                        $data2->save();

                        DB::commit();
                        //return back();
                        return response()->json([
                            'status' => 200,
                            'message' => 'บันทึกข้อมูลสำเร็จ',
                        ]);
                    }else{
                        return response()->json([
                            'status' => 404,
                            'message' => 'กรุณาเปิดหรือรอ location ก่อนค่ะ',
                        ]);
                    }

                } catch (\Exception $e) {
                    DB::rollback();
                    // return back();
                    return response()->json([
                        'status' => 404,
                        'message' => 'ไม่สามารถบันทึกได้',
                    ]);
                }
            }
            elseif ($chk_status->status_result == 1) {

                DB::beginTransaction();
                try {

                    if($request->lat != "" && $request->lon != ""){

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

                        DB::commit();
                        // return back();
                        return response()->json([
                            'status' => 200,
                            'message' => 'บันทึกข้อมูลสำเร็จ',
                        ]);

                    }else{
                        return response()->json([
                            'status' => 404,
                            'message' => 'กรุณาเปิดหรือรอ location ก่อนค่ะ',
                        ]);
                    }

                } catch (\Exception $e) {
                    DB::rollback();
                    // return back();
                    return response()->json([
                        'status' => 404,
                        'message' => 'ไม่สามารถบันทึกได้',
                    ]);
                }
            }

    }

    public function saleplan_result_get($id)
    {
        $dataResult = SalePlan::leftjoin('sale_plan_results', 'sale_plans.id', 'sale_plan_results.sale_plan_id')
        ->leftjoin('master_objective_saleplans', 'sale_plans.sale_plans_objective', 'master_objective_saleplans.id')
        ->where('sale_plans.id', $id)
        ->select('sale_plan_results.*',
        'sale_plans.sale_plans_title',
        'master_objective_saleplans.masobj_title',
        'sale_plans.sale_plans_tags',
        'sale_plans.customer_shop_id')->first();


         // -----  API สินค้านำเสนอ----------- //
         $api_token = $this->api_token->apiToken();
         $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
         $res_api = $response->json();

        // $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            if ($dataResult->customer_shop_id == $value['identify']) {
                $customer_api = $value['amphoe_name']." , ".$value['province_name'];
                $customer_name = $value['title']." ".$value['name'];
            }
        }

         $path_search = "pdglists?sortorder=DESC";
         $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
         $res_api = $response->json();

         $pdglists_api = array();
         foreach ($res_api['data'] as $key => $value) {
             $pdglists_api[$key] =
             [
                 'identify' => $value['identify'],
                 'name' => $value['name'],
                 'sub_code' => $value['sub_code'],
             ];
         }


    $data = array(
        'dataResult'     => $dataResult,
        'pdglists_api' => $pdglists_api,
        'customer_api' => $customer_api,
        'customer_name' => $customer_name
    );
    echo json_encode($data);

    }

    public function saleplan_result(Request $request)
    { // สรุปผลลัพธ์
        // dd($request);

        DB::beginTransaction();
        try {

            if($request->saleplan_result != ""){

                SalePlan::find($request->saleplan_id)->update([
                    'status_result' => 3,
                ]);
                $data2 = SalePlanResult::where('sale_plan_id', $request->saleplan_id)->first();
                if ($data2) {
                    $data2->sale_plan_detail   = $request->saleplan_detail;
                    $data2->sale_plan_status   = $request->saleplan_result;
                    $data2->updated_by   = Auth::user()->id;
                    $data2->updated_at   = Carbon::now();
                    $data2->update();
                }else{
                    $data_create = new SalePlanResult;
                    $data_create->sale_plan_id  = $request->saleplan_id;
                    $data_create->sale_plan_detail   = $request->saleplan_detail;
                    $data_create->sale_plan_status   = $request->saleplan_result;
                    $data_create->updated_by   = Auth::user()->id;
                    $data_create->updated_at   = Carbon::now();
                    $data_create->save();
                }

                // return back();

                $saleplan_month = SalePlan::find($request->saleplan_id);
                $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->where('id', $saleplan_month->monthly_plan_id)->first();

                DB::table('monthly_plans')->where('id', $monthly_plan->id)
                ->update([
                    'success_plan' => $monthly_plan->success_plan + 1,
                    'outstanding_plan' => $monthly_plan->outstanding_plan-1,
                ]);

                $events = DB::table('events')->where('sale_plans_id', $request->saleplan_id)->first();
                if(is_null($events)){
                    DB::table('events')
                    ->insert([
                        'title' => $saleplan_month->sale_plans_title,
                        'start' => Carbon::now(),
                        'end' => Carbon::now(),
                        'sale_plans_id' => $request->saleplan_id,
                        'created_by' => Auth::user()->id
                    ]);
                }

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                ]);

            }else{

                return response()->json([
                    'status' => 404,
                    'message' => 'กรุณาเลือกสรุปผลลัพธ์ด้วยค่ะ',
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกได้',
            ]);
        }
    }
}
