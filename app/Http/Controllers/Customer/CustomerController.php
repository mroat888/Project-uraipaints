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
        $data['customer_shop'] = DB::table('customer_shops')
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
        DB::beginTransaction();
        try {
            $path = 'upload/CustomerImage';
            $image = '';
            if (!empty($request->file('image'))) {
                $img = $request->file('image');
                $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }

            $pathFle = 'upload/CustomerFile';
            $uploadfile = '';
            if (!empty($request->file('shop_fileupload'))) {
                $uploadF = $request->file('shop_fileupload');
                $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
                $save_path2 = $uploadF->move(public_path($pathFle), $file_name);
                $uploadfile = $file_name;
            }

            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

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

            DB::table('monthly_plans')->where('id', $monthly_plan->id)
            ->update([
                'cust_new_amount' => $monthly_plan->cust_new_amount+1,
                'total_plan' => $monthly_plan->total_plan+1,
                'outstanding_plan' => ($monthly_plan->total_plan + 1) - $monthly_plan->success_plan,
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

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $request,
            ]);

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

        $dataEdit = DB::table('customer_shops')
            ->where('id', $id)
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

        return response()->json([
            'status' => 200,
            'dataEdit' => $dataEdit,
            'customer_contacts' => $customer_contacts,
            'shop_province' => $shop_province,
            'shop_amphur' => $shop_amphur,
            'shop_district' => $shop_district,
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
        DB::table('customer_shops')
            ->where('id', $request->id)
            ->update([
                'shop_status' => '3',
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
        DB::commit();
        // return back();
        echo ("<script>alert('ลบข้อมูลสำเร็จ'); location.href='planMonth'; </script>");
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

                $chk_status = Customer::where('id', $request->id)->first();
                if ($chk_status->shop_checkin_date) {

                    $data2 = Customer::where('id', $request->id)->first();
                    $data2->shop_checkout_date   = Carbon::now();
                    $data2->checkout_latitude   = $request->lat;
                    $data2->checkout_longitude   = $request->lon;
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
                    $data2 = Customer::where('id', $request->id)->first();
                    $data2->shop_checkin_date   = Carbon::now();
                    $data2->checkin_latitude   = $request->lat;
                    $data2->checkin_longitude   = $request->lon;
                    $data2->updated_by   = Auth::user()->id;
                    $data2->updated_at   = Carbon::now();
                    $data2->update();
                    // return back();
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลสำเร็จ',
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
        // $dataResult = Customer::find($id);
        // $data = array(
        //     'dataResult'     => $dataResult,
        // );
        // echo json_encode($data);

        $cus_shops = DB::table('customer_shops')->where('id', $id)->first();
        $cus_his = DB::table('customer_history_contacts')
        ->where('customer_shop_id', $cus_shops->id)
        ->whereDate('cust_history_saleplan_date', $cus_shops->shop_saleplan_date)
        ->orderby('id', 'desc')
        ->first();

        if(!is_null($cus_his)){
            return response()->json([
                'status' => 200,
                'dataResult' => $cus_his,
            ]);
        }

    }

    public function customer_new_Result(Request $request)
    { // สรุปผลลัพธ์
        // dd($request);
        DB::beginTransaction();
        try {
            if($request->cust_id !="" && $request->shop_result_status != ""){

                $data2 = Customer::where('id', $request->cust_id)->first();
                $data2->shop_result_detail   = $request->shop_result_detail;
                $data2->shop_result_status   = $request->shop_result_status;
                $data2->updated_by   = Auth::user()->id;
                $data2->updated_at   = Carbon::now();
                $data2->update();
<<<<<<< HEAD
                //return back();

                $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->where('id', $data2->monthly_plan_id)->first();


                DB::table('monthly_plans')->where('id', $monthly_plan->id)
            ->update([
                'success_plan' => $monthly_plan->success_plan + 1,
                'outstanding_plan' => $monthly_plan->outstanding_plan-1,
            ]);

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                ]);
=======
                // return back();

                if($request->cust_history_id != "" ){ // update

                    DB::table('customer_history_contacts')
                    ->where('id', $request->cust_history_id)
                    ->update([
                        'employee_id' => Auth::user()->id,
                        'cust_history_detail' => $request->shop_result_detail,
                        'cust_history_result_status' => $request->shop_result_status,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => Carbon::now(),
                    ]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลสำเร็จ',
                    ]);

                }else{

                    $cus_shops = DB::table('customer_shops')->where('id', $request->cust_id)->first();

                    DB::table('customer_history_contacts')
                        ->insert([
                            'customer_shop_id' => $request->cust_id,
                            'cust_history_saleplan_date' => $cus_shops->shop_saleplan_date,
                            'employee_id' => Auth::user()->id,
                            'cust_history_detail' => $request->shop_result_detail,
                            'cust_history_result_status' => $request->shop_result_status,
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        ]);

                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลสำเร็จ',
                    ]);
                }
>>>>>>> f87575ee5fdfe9fb47b3f42a3bdc92e3e024d1d3

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
