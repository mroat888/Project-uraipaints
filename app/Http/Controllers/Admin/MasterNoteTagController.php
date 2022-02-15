<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NoteTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterNoteTagController extends Controller
{

    public function index()
    {
        $tags = NoteTag::orderBy('id', 'desc')->get();
        return view('admin.master_tags', compact('tags'));
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

                DB::table('master_note')
                ->insert([
                   'name_tag' => $request->name_tag,
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
       $dataEdit = NoteTag::find($id);
       $data = array(
           'dataEdit'  => $dataEdit,
       );
       echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

                DB::table('master_note')->where('id',$request->id)
                ->update([
                    'name_tag'       => $request->name_tag_edit,
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
        NoteTag::where('id', $id)->delete();
        return back();
    }
}
