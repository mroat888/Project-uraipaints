<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Note;

class NoteController extends Controller
{

    public function note_sale()
    {
        $data = Note::orderBy('id', 'desc')->get();
        return view('saleman.note', compact('data'));
    }

    public function note_lead()
    {
        $data = Note::orderBy('id', 'desc')->get();
        return view('leadManager.note', compact('data'));
    }

    public function note_head()
    {
        $data = Note::orderBy('id', 'desc')->get();
        return view('headManager.note', compact('data'));
    }

    public function note_admin()
    {
        $data = Note::orderBy('id', 'desc')->get();
        return view('admin.note', compact('data'));
    }

    public function store(Request $request)
    {
        Note::create([
            'note_date' => $request->note_date,
            'note_title' => $request->note_title,
            'note_detail' => $request->note_detail,
            'note_tags' => $request->note_tags,
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
}
