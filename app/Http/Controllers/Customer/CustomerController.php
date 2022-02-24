<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\ObjectiveCustomer;
use App\CustomerVisit;
use App\ObjectiveSaleplan;
// use App\CustomerVisit;
use App\MonthlyPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// use DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        $data['customer_shop'] = DB::table('customer_shops')
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->where('customer_shops.shop_status', 1) // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , 2 = ลบ
            ->where('customer_shops.created_by', Auth::user()->id)
            ->select(
                'province.PROVINCE_NAME',
                'customer_shops.*'
            )
            ->orderBy('customer_shops.id', 'desc')
            ->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        return view('customer.customer', $data);
    }

    public function customerLead()
    {
        $data['customer_shops'] = DB::table('customer_shops')
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , 2 = ลบ
            ->where('customer_shops.created_by', Auth::user()->id)
            ->select(
                'province.PROVINCE_NAME',
                'customer_shops.*'
            )
            ->orderBy('customer_shops.id', 'desc')
            ->get();

        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        return view('customer.lead', $data);
    }

    public function store(Request $request)
    {
        // -- หา ID ของ MonthlyPlan
        if($request->is_monthly_plan == 'N'){ // นอกแผนงาน ทำในระบบ ลูกค้าใหม่ตรงๆ
            list($year,$month,$day) = explode('-',date('Y-m-d'));
            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)
            ->whereYear('month_date', '=', $year)
            ->whereMonth('month_date', '=', $month)
            ->orderBy('month_date', 'desc')
            ->first();
            $shop_aprove_status = "1";
        }else{ // ในแผนงาน ทำในระบบ แผนงานประจำเดือน
            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();
            $shop_aprove_status = "0";
        }

        // dd($monthly_plan);

        DB::beginTransaction();
        try {
            if($request->customer_shops_id != ""){ // ถ้ามีการค้นหาร้านค้าที่มีในระบบ

                // $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();
                //-- เพิ่ม monthly_plans
                DB::table('monthly_plans')->where('id', $monthly_plan->id)
                    ->update([
                        'cust_new_amount' => $monthly_plan->cust_new_amount+1,
                        'total_plan' => $monthly_plan->total_plan+1,
                        'outstanding_plan' => ($monthly_plan->total_plan + 1) - $monthly_plan->success_plan,
                    ]);

                // //-- เพิ่ม customer_shops_saleplan
                DB::table('customer_shops_saleplan')
                    ->insert([
                        'customer_shop_id' => $request->customer_shops_id,
                        'customer_shop_objective' => $request->customer_shop_objective,
                        'shop_aprove_status' => $shop_aprove_status,
                        'is_monthly_plan' => $request->is_monthly_plan,
                        'monthly_plan_id' => $monthly_plan->id,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ]);

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                    'data' => $request,
                ]);

            }else{ // ถ้าไม่มีให้เพิ่มร้านค้าเข้าไปใหม่

                $path = 'upload/CustomerImage';
                $image = '';
                $pathFle = 'upload/CustomerFile';
                $uploadfile = '';

                DB::table('customer_shops')
                ->insert([
                    'monthly_plan_id'     => $monthly_plan->id,
                    'shop_name'           => $request->shop_name,
                    'shop_address'        => $request->shop_address,
                    'shop_province_id'    => $request->province,
                    'shop_amphur_id'      => $request->amphur,
                    'shop_district_id'    => $request->district,
                    'shop_zipcode'        => $request->shop_zipcode,
                    'shop_profile_image'  => $image,
                    'shop_fileupload'     => $uploadfile,
                    'shop_status'         => 0,
                    'shop_saleplan_date'  => Carbon::now()->addMonth(1),
                    'created_by'          => Auth::user()->id,
                    'created_at'          => Carbon::now(),
                ]);

                $sql_shops = DB::table('customer_shops')->orderBy('customer_shops.id', 'desc')->first();

                DB::table('customer_contacts')
                    ->insert([
                        'customer_shop_id' => $sql_shops->id,
                        'customer_contact_name' => $request->contact_name,
                        'customer_contact_phone' => $request->shop_phone,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ]);

                //-- เพิ่ม monthly_plans
                DB::table('monthly_plans')->where('id', $monthly_plan->id)
                    ->update([
                        'cust_new_amount' => $monthly_plan->cust_new_amount+1,
                        'total_plan' => $monthly_plan->total_plan+1,
                        'outstanding_plan' => ($monthly_plan->total_plan + 1) - $monthly_plan->success_plan,
                    ]);

                // //-- เพิ่ม customer_shops_saleplan
                DB::table('customer_shops_saleplan')
                    ->insert([
                        'customer_shop_id' => $sql_shops->id,
                        'customer_shop_objective' => $request->customer_shop_objective,
                        'shop_aprove_status' => $shop_aprove_status,
                        'is_monthly_plan' => $request->is_monthly_plan,
                        'monthly_plan_id' => $monthly_plan->id,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ]);

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                    'data' => $request,
                ]);
            }

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
                'data' => $request,
            ]);
        }


    }

    public function edit($id)
    {
        $dataEdit = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
        ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
            ->where('customer_shops_saleplan.customer_shop_id', $id)
            ->select(
                'master_customer_new.*',
                'customer_shops.*', 
                'customer_shops_saleplan.*'
            )
            ->first();

        $customer_contacts = DB::table('customer_contacts')
            ->where('customer_shop_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $shop_province = DB::table('province')->get();

        $shop_amphur = DB::table('amphur')
            ->where('PROVINCE_ID', $dataEdit->shop_province_id)
            ->get();

        $shop_district = DB::table('district')
            ->where('AMPHUR_ID', $dataEdit->shop_amphur_id)
            ->get();

        $master_customer_new = DB::table('master_customer_new')->orderBy('id','asc')->get();

        return response()->json([
            'status' => 200,
            'dataEdit' => $dataEdit,
            'customer_contacts' => $customer_contacts,
            'shop_province' => $shop_province,
            'shop_amphur' => $shop_amphur,
            'shop_district' => $shop_district,
            'master_customer_new' => $master_customer_new,
        ]);
    }

    public function edit_shopsaleplan($id){
        $dataEdit = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
        ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
        ->where('customer_shops_saleplan.id', $id)
        ->select(
            'master_customer_new.*',
            'customer_contacts.*',
            'customer_shops.*', 
            'customer_shops_saleplan.*',
            'customer_shops.id as shop_id',
        )
        ->first();

        $customer_contacts = DB::table('customer_contacts')
            ->where('customer_shop_id', $dataEdit->shop_id)
            ->orderBy('id', 'desc')
            ->first();

        $shop_province = DB::table('province')->get();

        $shop_amphur = DB::table('amphur')
            ->where('PROVINCE_ID', $dataEdit->shop_province_id)
            ->get();

        $shop_district = DB::table('district')
            ->where('AMPHUR_ID', $dataEdit->shop_amphur_id)
            ->get();

        $master_customer_new = DB::table('master_customer_new')->orderBy('id','asc')->get();

        return response()->json([
            'status' => 200,
            'dataEdit' => $dataEdit,
            'customer_contacts' => $customer_contacts,
            'shop_province' => $shop_province,
            'shop_amphur' => $shop_amphur,
            'shop_district' => $shop_district,
            'master_customer_new' => $master_customer_new,
        ]);
    }

    public function update(Request $request)
    {
        //dd($request);
        //$base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
        $path = 'upload/CustomerImage';
        $image = '';
        $pathFile = 'upload/CustomerFile';
        $uploadfile = '';

        if ($request->edit_image != '') {
            if (!empty($request->file('edit_image'))) {

                $data = Customer::find($request->edit_shop_id);

                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->shop_profile_image)) {
                    $path2 = 'upload/CustomerImage/';
                    unlink(public_path($path2 . $data->shop_profile_image));
                }

                $img = $request->file('edit_image');
                $img_name = 'stores-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }
        }

        if ($request->edit_shop_fileupload != '') {
            if (!empty($request->file('edit_shop_fileupload'))) {

                $datafile = Customer::find($request->edit_shop_id);

                //ลบไฟล์เก่าเพื่ออัพโหลดไฟล์ใหม่แทน
                if (!empty($datafile->shop_fileupload)) {
                    $pathFile2 = 'upload/CustomerFile/';
                    unlink(public_path($pathFile2 . $datafile->shop_fileupload));
                }

                $uploadF = $request->file('edit_shop_fileupload');
                $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
                $save_path2 = $uploadF->move(public_path($pathFile), $file_name);
                $uploadfile = $file_name;
            }
        }


        if ($image != '' && $uploadfile != '') {

            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->shop_profile_image  = $image;
                $data2->shop_fileupload     = $uploadfile;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    DB::table('customer_shops_saleplan')
                    ->where('customer_shop_id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_shop_objective' => $request->edit_customer_shop_objective,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } elseif ($image != '' && $uploadfile == '') {
            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->shop_profile_image  = $image;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::table('customer_shops_saleplan')
                ->where('customer_shop_id', $request->edit_cus_contacts_id)
                ->update([
                    'customer_shop_objective' => $request->edit_customer_shop_objective,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } elseif ($image == '' && $uploadfile != '') {
            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->shop_fileupload     = $uploadfile;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::table('customer_shops_saleplan')
                ->where('customer_shop_id', $request->edit_cus_contacts_id)
                ->update([
                    'customer_shop_objective' => $request->edit_customer_shop_objective,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    DB::table('customer_shops_saleplan')
                    ->where('customer_shop_id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_shop_objective' => $request->edit_customer_shop_objective,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        //echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='lead'; </script>");

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data' => $request,
        ]);
    }

    public function show($id)
    {
        // dd($id);

        $data['customer_shops'] = DB::table('customer_shops')
            ->where('id', $id)
            ->first();

        $data['customer_contacts'] = DB::table('customer_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->first();

        $data['customer_history_contacts'] = DB::table('customer_history_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->get();

        $data['customer_shops_saleplan'] = DB::table('customer_shops_saleplan')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('monthly_plan_id', 'desc')
            ->get();

        return view('customer.customer_detail', $data);
    }

    public function lead_to_customer(Request $request)
    {

        DB::beginTransaction();
        try {

            DB::table('customer_shops')
                ->where('id', $request->shop_id)
                ->update([
                    'shop_status' => '1',
                    'updated_by' => Auth::user()->id,
                    'shop_status_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'อัพเดทสถานะสำเร็จ',
        ]);
    }

    public function customer_delete(Request $request)
    {

        DB::beginTransaction();
        try {

            DB::table('customer_shops')
                ->where('id', $request->shop_id_delete)
                ->update([
                    'shop_status' => '3',
                    'deleted_by' => Auth::user()->id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);

            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

            DB::table('monthly_plans')->where('id', $monthly_plan->id)
            ->update([
                'cust_new_amount' => $monthly_plan->cust_new_amount-1,
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

    public function customer_shops_saleplan_delete(Request $request){

        DB::beginTransaction();
        try {

            DB::table('customer_shops_saleplan')
                ->where('id', $request->shop_id_delete)->delete();
                
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลลูกค้าเรียบร้อยแล้ว',
        ]);

    }


    public function destroy(Request $request)
    {
        // DB::table('customer_shops')
        //     ->where('id', $request->id)
        //     ->update([
        //         'shop_status' => '3',
        //         'deleted_by' => Auth::user()->id,
        //         'deleted_at' => date('Y-m-d H:i:s'),
        //     ]);

        //     $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

        //     DB::table('monthly_plans')->where('id', $monthly_plan->id)
        //     ->update([
        //         'cust_new_amount' => $monthly_plan->cust_new_amount-1,
        //         'total_plan' => $monthly_plan->total_plan-1,
        //         'outstanding_plan' => $monthly_plan->total_plan-1,
        //     ]);
        // DB::commit();
        // // return back();
        // echo ("<script>alert('ลบข้อมูลสำเร็จ'); location.href='planMonth'; </script>");
    }

    public function fetch_autocomplete()
    {
        $term = Input::get('term');
        $results = array();
        dd($term);
        $query = DB::table('customer_shops')
            ->where('shop_name', 'LIKE', '%' . $term . '%')
            ->get();
        return Response::json($results);
    }

    public function customer_new_checkin(Request $request)
    { // เช็คอิน-เช็คเอ้าท์
       // dd($request);
        DB::beginTransaction();
        try {

            if($request->lat != "" && $request->lon != ""){

                $chk_status = DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $request->id)->first();
                // dd($request->id, $chk_status);
                if ($chk_status) {
                    DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $request->id)
                    ->update([
                        'cust_result_checkout_date' => Carbon::now(),
                        'cust_result_checkout_latitude' => $request->lat,
                        'cust_result_checkout_longitude' => $request->lon,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => Carbon::now(),
                    ]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'เช็คเอาท์สำเร็จ',
                    ]);
                }else{
                    DB::table('customer_shops_saleplan_result')
                        ->insert([
                            'customer_shops_saleplan_id' => $request->id,
                            'cust_result_checkin_date' => Carbon::now(),
                            'cust_result_checkin_latitude' => $request->lat,
                            'cust_result_checkin_longitude' => $request->lon,
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        ]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'เช็คอินสำเร็จ',
                    ]);
                }
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
                'data' => $request->id,
            ]);
        }
    }

    public function customer_new_result_get($id)
    {

        $cus_result = DB::table('customer_shops_saleplan_result')
            ->where('customer_shops_saleplan_id', $id)
            ->first();

        if(!is_null($cus_result)){
            return response()->json([
                'status' => 200,
                'dataResult' => $cus_result,
            ]);
        }

    }

    public function customer_new_Result(Request $request)
    { // สรุปผลลัพธ์
        // dd($request);
        DB::beginTransaction();
        try {
            if($request->cust_id !="" && $request->shop_result_status != ""){

                DB::table('customer_shops_saleplan_result')->where('id', $request->cust_id)
                ->update([
                    'cust_result_detail' => $request->shop_result_detail,
                    'cust_result_status' => $request->shop_result_status,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now()
                ]);

                $cust_shops_saleplan_result = DB::table('customer_shops_saleplan_result')->where('id', $request->cust_id)->first();
                $cust_shops_saleplan = DB::table('customer_shops_saleplan')->where('id', $cust_shops_saleplan_result->customer_shops_saleplan_id)->first();
                $customer_name = DB::table('customer_shops')->where('id', $cust_shops_saleplan->customer_shop_id)->first();

                $events = DB::table('events')->where('customer_shops_saleplan_id', $cust_shops_saleplan->id)->first();

                // dd($customer_name->shop_name);

                if(is_null($events)){
                    DB::table('events')
                    ->insert([
                        'title' => $customer_name->shop_name,
                        'start' => Carbon::now(),
                        'end' => Carbon::now(),
                        'customer_shops_saleplan_id' => $cust_shops_saleplan->id,
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

    public function fetch_customer_shops(){
        
    }


}
