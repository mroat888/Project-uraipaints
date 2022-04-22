<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MasterCustomerNew;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MastrCustomerNewController extends Controller
{
    public function index()
    {
        $cust_new = MasterCustomerNew::orderBy('id', 'desc')->get();
        return view('admin.master_customer_new', compact('cust_new'));
    }

    public function store(Request $request)
    {
         // dd($request);
         DB::beginTransaction();
         try {

                 DB::table('master_customer_new')
                 ->insert([
                    'cust_name'           => $request->cust_name,
                    'created_at'          => Carbon::now(),
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
        $dataEdit = MasterCustomerNew::find($id);
        $data = array(
            'dataEdit'  => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

                DB::table('master_customer_new')->where('id',$request->id)
                ->update([
                    'cust_name'       => $request->cust_name_edit,
                    'updated_at'          => Carbon::now(),
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

    public function destroy($id)
    {
        MasterCustomerNew::where('id', $id)->delete();
        return back();
    }
}
