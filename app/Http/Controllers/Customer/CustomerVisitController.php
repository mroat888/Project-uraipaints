<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\ObjectiveSaleplan;
use App\CustomerVisit;
use App\CustomerVisitResult;
use App\MonthlyPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Http\Controllers\Api\ApiController;


class CustomerVisitController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function visit()
    {
        $objective = ObjectiveSaleplan::all();
        $list_visit = CustomerVisit::join('customer_shops', 'customer_visits.customer_shop_id', '=', 'customer_shops.id')
            ->select('customer_shops.shop_name', 'customer_visits.id', 'customer_visits.customer_visit_date')
            ->where('customer_visits.created_by', Auth::user()->id) // OAT เพิ่ม
            ->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)
            ->get(env("API_LINK") . 'api/v1/sellers/' . Auth::user()->api_identify . '/customers');
        $res_api = $response->json();
        // $res_api = $res['data'];

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] =
                [
                    'id' => $value['identify'],
                    'shop_name' => $value['title'] . " " . $value['name'],
                ];
        }
        // -----  END API

        return view('saleman.visitCustomers', compact('objective', 'list_visit', 'customer_api',));
    }

    public function VisitStore(Request $request)
    {
        // -- หา ID ของ MonthlyPlan
        list($year, $month, $day) = explode('-', $request->date);
        $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)
            ->whereYear('month_date', '=', $year)
            ->whereMonth('month_date', '=', $month)
            ->orderBy('month_date', 'desc')
            ->first();

        DB::beginTransaction();
        try {

            // ให้บวก จำนวนเยี่ยมลูกค้าใน MonthlyPlan ในเดือนนั้น
            $visits_amount = $monthly_plan->cust_visits_amount + 1;
            DB::table('monthly_plans')
                ->where('id', $monthly_plan->id)
                ->update([
                    'cust_visits_amount' => $visits_amount,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            $date = Carbon::parse($monthly_plan->month_date)->format('Y-m');
            $datenext = Carbon::today()->addMonth(1)->format('Y-m');
            if ($date == $datenext) {

                DB::table('customer_visits')
                    ->insert([
                        'monthly_plan_id' => $monthly_plan->id, // ID ของ MonthlyPlan
                        'customer_shop_id' => $request->shop_id,
                        'customer_visit_date' => $request->date,
                        'customer_visit_tags' => $request->product,
                        'customer_visit_objective' => $request->visit_objective,
                        'is_monthly_plan' => 'Y', // อยู่ในแผน
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
            } else {

                DB::table('customer_visits')
                    ->insert([
                        'monthly_plan_id' => $monthly_plan->id, // ID ของ MonthlyPlan
                        'customer_shop_id' => $request->shop_id,
                        'customer_visit_date' => $request->date,
                        'customer_visit_tags' => $request->product,
                        'customer_visit_objective' => $request->visit_objective,
                        'is_monthly_plan' => 'N', // เพิ่มระหว่างเดือน
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $monthly_plan->id,
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกได้',
                'data' => $monthly_plan->id,
            ]);
        }
    }


    public function VisitStore2(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('customer_contacts')
                ->insert([
                    'customer_shop_id' => $request->shop_id,
                    'customer_visit_date' => $request->date,
                    'customer_visit_tags' => $request->product,
                    'customer_visit_objective' => $request->visit_objective,
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

    public function edit_customerVisit($id)
    {
        // $visit = CustomerVisit::find($id);
        $visit = CustomerVisit::join('customer_shops', 'customer_visits.customer_shop_id', '=', 'customer_shops.id')
            ->where('customer_visits.id', $id)->select(
                'customer_shops.contact_name',
                'customer_shops.shop_phone',
                'customer_shops.shop_address',
                'customer_shops.id as shop_id',
                'customer_visits.id',
                'customer_visits.customer_visit_date',
                'customer_visits.customer_visit_tags',
                'customer_visits.customer_visit_objective'
            )->first();

        $data = array(
            'visit'     => $visit,
        );
        echo json_encode($data);
    }

    public function update_customerVisit(Request $request)
    {
        // dd($request);
        CustomerVisit::find($request->id)->update([
            'customer_shop_id' => $request->shop_id,
            'customer_visit_date' => $request->date,
            'customer_visit_tags' => $request->product,
            'customer_visit_objective' => $request->visit_objective,
            'updated_by' => Auth::user()->id,
        ]);
        echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='visit'; </script>");
    }

    public function destroy(Request $request)
    {

        DB::beginTransaction();
        try {

            CustomerVisit::where('id', $request->cust_visit_id_delete)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลลูกค้าเรียบร้อยแล้ว',
        ]);

        return back();
    }

    public function fetch_customer_shops_visit($id)
    {
        // -----  API
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK") . 'api/v1/customers/' . $id);
        $res_api = $response->json();

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] =
                [
                    'id' => $value['identify'],
                    'shop_name' => $value['title'] . " " . $value['name'],
                    'shop_address' => $value['address1'] . " " . $value['adrress2'],
                    'shop_phone' => $value['telephone'],
                    'shop_mobile' => $value['mobile'],
                ];
        }
        // -----  END API

        // $result = DB::table('customer_shops')
        //     ->join('customer_contacts', 'customer_contacts.customer_shop_id', 'customer_shops.id')
        //     ->where('customer_shops.id', $id)
        //     ->select([
        //         'customer_contacts.*',
        //         'customer_shops.*'
        //     ])
        //     ->first();

        // return response()->json($result);
        return response()->json($customer_api);
    }

    public function customer_visit_checkin(Request $request)
    { // เช็คอิน-เช็คเอ้าท์
        // dd($request);

        DB::beginTransaction();
        try {

            if ($request->lat != "" && $request->lon != "") {

                $chk_status = CustomerVisitResult::where('customer_visit_id', $request->id)->first();
                if ($chk_status) {
                    $data2 = CustomerVisitResult::where('customer_visit_id', $request->id)->first();
                    $data2->cust_visit_checkout_date   = Carbon::now();
                    $data2->cust_visit_checkout_latitude   = $request->lat;
                    $data2->cust_visit_checkout_longitude   = $request->lon;
                    $data2->updated_by   = Auth::user()->id;
                    $data2->updated_at   = Carbon::now();
                    $data2->update();
                    //return back();
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลสำเร็จ',
                    ]);
                } else {
                    $data2 = new CustomerVisitResult;
                    $data2->customer_visit_id = $request->id;
                    $data2->cust_visit_checkin_date   = Carbon::now();
                    $data2->cust_visit_checkin_latitude   = $request->lat;
                    $data2->cust_visit_checkin_longitude   = $request->lon;
                    $data2->created_by   = Auth::user()->id;
                    $data2->created_at   = Carbon::now();
                    $data2->save();
                    // return back();
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลสำเร็จ',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'กรุณาเปิดหรือรอ location ก่อนค่ะ',
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

    public function customer_visit_result_get($id)
    {
        $dataResult = CustomerVisit::leftjoin('customer_shops', 'customer_visits.customer_shop_id', 'customer_shops.id')
            ->leftjoin('customer_visit_results', 'customer_visits.id', 'customer_visit_results.customer_visit_id')
            ->leftjoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
            ->leftjoin('master_objective_visit', 'customer_visits.customer_visit_objective', 'master_objective_visit.id')
            ->where('customer_visits.id', $id)
            ->select('customer_shops.shop_name', 'customer_visits.*',
            'customer_visit_results.cust_visit_detail',
            'customer_visit_results.cust_visit_status',
            'customer_contacts.customer_contact_name',
            'master_objective_visit.visit_name')
            ->first();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK") . env("API_PATH_VER") . '/sellers/' . Auth::user()->api_identify . '/customers');
        $res_api = $response->json();

        // $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            if ($dataResult->customer_shop_id == $value['identify']) {
                $visit_address = $value['amphoe_name'] . " , " . $value['province_name'];
                $visit_name = $value['title'] . " " . $value['name'];
            } else {
                // $visit_name = "fff";
                // $visit_address = $dataResult->AMPHUR_NAME . ", " . $dataResult->PROVINCE_NAME;
            }
        }

           if(!is_null($dataResult)){
               return response()->json([
                   'status' => 200,
                   'dataResult' => $dataResult,
                   'visit_name' => $visit_name,
                   'visit_address' => $visit_address,
                   'id' => $dataResult->customer_shop_id
               ]);
           }

        // $dataResult = CustomerVisitResult::where('customer_visit_id', $id)->first();


        $data = array(
            'dataResult'     => $dataResult,
            'visit_name' => $visit_name,
            'visit_address' => $visit_address,
            'id' => $id
        );
        echo json_encode($data);
    }

    public function customer_visit_Result(Request $request)
    { // สรุปผลลัพธ์
        // dd($request);

        DB::beginTransaction();
        try {
            if ($request->visit_result_status != "") {

                $data2 = CustomerVisitResult::where('customer_visit_id', $request->visit_id)->first();
                if ($data2 != '') {
                    $data2->cust_visit_detail   = $request->visit_result_detail;
                    $data2->cust_visit_status   = $request->visit_result_status;
                    $data2->updated_by   = Auth::user()->id;
                    $data2->updated_at   = Carbon::now();
                    $data2->update();
                }else{
                    $data_create = new CustomerVisitResult;
                    $data_create->customer_visit_id   = $request->visit_id;
                    $data_create->cust_visit_detail   = $request->visit_result_detail;
                    $data_create->cust_visit_status   = $request->visit_result_status;
                    $data_create->updated_by   = Auth::user()->id;
                    $data_create->updated_at   = Carbon::now();
                    $data_create->save();
                }


                $cust_visit = DB::table('customer_visits')->where('id', $request->visit_id)->first();

                $events = DB::table('events')->where('customer_visits_id', $request->visit_id)->first();


                if (is_null($events)) {
                    DB::table('events')
                        ->insert([
                            'title' => "เยี่ยมลูกค้า : " . $cust_visit->customer_shop_id,
                            'start' => Carbon::now(),
                            'end' => Carbon::now(),
                            'customer_visits_id' => $cust_visit->id,
                            'created_by' => Auth::user()->id
                        ]);
                }

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                ]);
            } else {
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
