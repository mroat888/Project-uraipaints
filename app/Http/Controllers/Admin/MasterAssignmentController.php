<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ObjectiveAssign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterAssignmentController extends Controller
{

    public function index()
    {
        $master_assignment = ObjectiveAssign::orderBy('id', 'desc')->get();
        return view('admin.master_assignment', compact('master_assignment'));
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

                DB::table('master_objective_assigns')
                ->insert([
                   'masassign_title' => $request->masassign_title,
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
        $dataEdit = ObjectiveAssign::find($id);
        $data = array(
            'dataEdit'  => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

                DB::table('master_objective_assigns')->where('id',$request->id)
                ->update([
                    'masassign_title'       => $request->masassign_title_edit,
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
        ObjectiveAssign::where('id', $id)->delete();
        return back();
    }
}
