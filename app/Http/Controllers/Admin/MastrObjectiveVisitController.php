<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ObjectiveVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MastrObjectiveVisitController extends Controller
{
    public function index()
    {
        $master_objective_visit = ObjectiveVisit::orderBy('id', 'desc')->get();
        return view('admin.master_objective_visit', compact('master_objective_visit'));
    }

    public function store(Request $request)
    {
         // dd($request);
         DB::beginTransaction();
         try {

                 DB::table('master_objective_visit')
                 ->insert([
                    'visit_name' => $request->visit_name,
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
        $dataEdit = ObjectiveVisit::find($id);
        $data = array(
            'dataEdit'  => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

                DB::table('master_objective_visit')->where('id',$request->id)
                ->update([
                    'visit_name'          => $request->visit_name_edit,
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
        ObjectiveVisit::where('id', $id)->delete();
        return back();
    }
}
