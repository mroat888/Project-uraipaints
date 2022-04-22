<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterSettingController extends Controller
{
    public function index(){
        $master_setting = DB::table('master_setting')->get();
        return view('admin.master_setting', compact('master_setting'));
    }

    public function update(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {

            foreach($request->set_id as $key => $value){
                DB::table('master_setting')->where('id',$value)
                ->update([
                    'stipulate' => $request->stipulate[$key],
                ]);
            }
            
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
}
