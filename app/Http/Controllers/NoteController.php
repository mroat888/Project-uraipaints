<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{

    public function note_sale()
    {
        $data = DB::table('notes')
        ->where('employee_id', Auth::user()->id)
        // ->where('status_pin', 1)
        ->orderBy('status_pin', 'desc')
        ->orderBy('note_date', 'asc')->get();
        return view('saleman.note', compact('data'));
    }

    public function note_lead()
    {
        $data = DB::table('notes')
        ->where('employee_id', Auth::user()->id)
        // ->where('status_pin', 1)
        ->orderBy('status_pin', 'desc')
        ->orderBy('note_date', 'asc')->get();
        return view('leadManager.note', compact('data'));
    }

    public function note_head()
    {
        $data = DB::table('notes')
        ->where('employee_id', Auth::user()->id)
        // ->where('status_pin', 1)
        ->orderBy('status_pin', 'desc')
        ->orderBy('note_date', 'asc')->get();
        return view('headManager.note', compact('data'));
    }

    public function note_admin()
    {
        $data = DB::table('notes')
        ->where('employee_id', Auth::user()->id)
        // ->where('status_pin', 1)
        ->orderBy('status_pin', 'desc')
        ->orderBy('note_date', 'asc')->get();
        return view('admin.note', compact('data'));
    }

    public function store(Request $request)
    {
        Note::create([
            'note_date' => $request->note_date,
            'note_title' => $request->note_title,
            'note_detail' => $request->note_detail,
            'note_tags' => $request->note_tags,
            'employee_id' => Auth::user()->id,
        ]);

        return back();
        // echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='note'; </script>");
    }

    public function edit($id)
    {
        $dataEdit = Note::find($id);
        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
         Note::find($request->id)->update([
            'note_date' => $request->note_date,
            'note_title' => $request->note_title,
            'note_detail' => $request->note_detail,
            'note_tags' => $request->note_tags,
        ]);

        return back();
        // echo ("<script>alert('แก้ไขข้อมูลสำเร็จ'); location.href='note'; </script>");
    }

    public function destroy($id)
    {
       Note::where('id', $id)->delete();
        return back();
        // echo ("<script>alert('ลบข้อมูลสำเร็จ'); location.href='note'; </script>");
    }

    public function status_pin_update($id)
    {
        // dd($id);
        $data = Note::where('id', $id)->where('status_pin', 1)->first();
        if ($data) {
            Note::find($id)->update([
                'status_pin' => 0,
            ]);
        }else {
            Note::find($id)->update([
                'status_pin' => 1,
            ]);
        }


        return back();
    }
}
