<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChangeCustomerController extends Controller
{

    public function index()
    {
        $data_customer_new = DB::table('customer_shops_saleplan')
        ->leftjoin('customer_shops', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
        ->leftjoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->leftjoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->leftjoin('users', 'customer_shops_saleplan.created_by', 'users.id')
        ->where('customer_shops_saleplan.shop_aprove_status', 2)
        ->where('customer_shops.shop_status', 0)
        ->select('customer_shops_saleplan.*',
        'users.name as saleman', 'customer_shops.shop_name', 'customer_shops.shop_status',
        'customer_shops.id as shop_id',
        'province.PROVINCE_NAME',
        'amphur.AMPHUR_NAME',)->get();

        $data = array(
            'data_customer_new'  => $data_customer_new,
        );

        return view('admin.change_customer_status', $data);
    }

    public function show($id)
    {
        $dataCustomer = DB::table('customer_shops_saleplan')
        ->leftjoin('customer_shops', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
        ->leftjoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
        ->leftjoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->leftjoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->leftjoin('district', 'district.DISTRICT_ID', 'customer_shops.shop_district_id')
        ->where('customer_shops.id', $id)
        ->select('customer_shops.*',
        'customer_contacts.customer_contact_name',
        'customer_contacts.customer_contact_phone',
        'province.PROVINCE_NAME as province',
        'amphur.AMPHUR_NAME as amphur',
        'district.DISTRICT_NAME as district')
        ->first();


        $data = array(
            'dataCustomer'  => $dataCustomer,
        );
        echo json_encode($data);
    }

    public function update_status(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
            try {
                DB::table('customer_shops')->where('id', $request->shop_id)->update([
                    'mrp_identify' => $request->mrp_identify,
                    'shop_status' => $request->status,
                    'shop_status_at' => Carbon::now(),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now(),
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $request,
            ]);
    }

    public function destroy($id)
    {
        //
    }
}
