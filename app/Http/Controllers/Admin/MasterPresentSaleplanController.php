<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MasterPresentSaleplan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterPresentSaleplanController extends Controller
{

    public function index()
    {
        $master_saleplan = MasterPresentSaleplan::orderBy('id', 'desc')->get();
        return view('admin.master_present_saleplan', compact('master_saleplan'));
    }

    public function store(Request $request)
    {
         // dd($request);
         DB::beginTransaction();
         try {

                 DB::table('master_present_saleplan')
                 ->insert([
                    'present_title' => $request->present_title,
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
        $dataEdit = MasterPresentSaleplan::find($id);
        $data = array(
            'dataEdit'  => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

                DB::table('master_present_saleplan')->where('id',$request->id)
                ->update([
                    'present_title'       => $request->present_title_edit,
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
        MasterPresentSaleplan::where('id', $id)->delete();
        return back();
    }
}
