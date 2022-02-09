<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ObjectiveSaleplan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterObjectiveSaleplanController extends Controller
{
    public function index()
    {
        $master_objective_saleplan = ObjectiveSaleplan::orderBy('id', 'desc')->get();
        return view('admin.master_objective_saleplan', compact('master_objective_saleplan'));
    }

    public function store(Request $request)
    {
         // dd($request);
         DB::beginTransaction();
         try {

                 DB::table('master_objective_saleplans')
                 ->insert([
                    'masobj_title' => $request->masobj_title,
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
        $dataEdit = ObjectiveSaleplan::find($id);
        $data = array(
            'dataEdit'  => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

                DB::table('master_objective_saleplans')->where('id',$request->id)
                ->update([
                    'masobj_title'       => $request->masobj_title_edit,
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
        ObjectiveSaleplan::where('id', $id)->delete();
        return back();
    }
}
