<?php

namespace App\Http\Controllers\SaleMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Note;

class NoteController extends Controller
{

    public function index()
    {
        $data = Note::orderBy('id', 'desc')->paginate(10);
        return view('saleman.note', compact('data'));
    }

    public function store(Request $request)
    {
        Note::create([
            'note_date' => $request->note_date,
            'note_title' => $request->note_title,
            'note_detail' => $request->note_detail,
            'note_tags' => $request->note_tags,
        ]);

        echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='note'; </script>");
    }

    public function show($id)
    {
        //
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

        echo ("<script>alert('แก้ไขข้อมูลสำเร็จ'); location.href='note'; </script>");
    }

    public function destroy($id)
    {
       Note::where('id', $id)->delete();
        return back();
        // echo ("<script>alert('ลบข้อมูลสำเร็จ'); location.href='note'; </script>");
    }
}
