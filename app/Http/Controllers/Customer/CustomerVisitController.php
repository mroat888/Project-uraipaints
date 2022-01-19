<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\ObjectiveSaleplan;
use App\CustomerVisit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class CustomerVisitController extends Controller
{

    public function visit()
    {
        $objective = ObjectiveSaleplan::all();
        $list_visit = CustomerVisit::join('customer_shops', 'customer_visits.customer_shop_id', '=', 'customer_shops.id')
            ->select('customer_shops.shop_name', 'customer_visits.id', 'customer_visits.customer_visit_date')
            ->where('customer_visits.created_by', Auth::user()->id) // OAT เพิ่ม
            ->get();

        // $customer_shops = DB::table('customer_shops')
        //     ->whereIn('shop_status', [0, 1]) // ดึงเฉพาะ ลูกค้าเป้าหมายและทะเบียนลูกค้า
        //     ->where('created_by', Auth::user()->id)
        //     ->orderby('shop_name', 'asc')
        //     ->get();

        // -----  API 
        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);
        $res = $response->json();
        $api_token = $res['data']['access_token'];

        $url_fetch = "api/v1/sellers/".Auth::user()->api_identify."/customers";
        $response = Http::get('http://49.0.64.92:8020/'.$url_fetch, [
            'token' => $api_token,
        ]);
        $res_api = $response->json();
        // $res_api = $res['data'];

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] = 
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
            ];
        }
        // -----  END API 

        return view('saleman.visitCustomers', compact('objective', 'list_visit', 'customer_api'));
    }

    public function VisitStore(Request $request)
    {
        DB::beginTransaction();
        try {

            CustomerVisit::create([
                    'monthly_plan_id' => $request->id,
                    'customer_shop_id' => $request->shop_id,
                    'customer_visit_date' => $request->date,
                    'customer_visit_tags' => $request->product,
                    'customer_visit_objective' => $request->visit_objective,
                    'created_by' => Auth::user()->id,
                    // 'created_at' => Carbon::now(),
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

    public function destroy($id)
    {
        CustomerVisit::where('id', $id)->delete();
        return back();
        // echo ("<script>alert('ลบข้อมูลสำเร็จ'); location.href='note'; </script>");
    }

    public function fetch_customer_shops_visit($id)
    {
        // -----  API 
        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);
        $res = $response->json();
        $api_token = $res['data']['access_token'];

        $url_fetch = "api/v1/sellers/".Auth::user()->api_identify."/customers";
        $response = Http::get('http://49.0.64.92:8020/'.$url_fetch, [
            'token' => $api_token,
        ]);
        $res_api = $response->json();

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] = 
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'address' => $value['address1']." ".$value['adrress2'],
                'telephone' => $value['telephone'],
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
        

        return response()->json($result);
    }
}
