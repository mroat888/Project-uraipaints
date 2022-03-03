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
        $data = DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();
        // dd($data);
        return view('saleman.note', compact('data'));
    }

    public function note_lead()
    {
        $data = DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();
        return view('leadManager.note', compact('data'));
    }

    public function note_head()
    {
        $data = DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();
        return view('headManager.note', compact('data'));
    }

    public function note_admin()
    {
        $data = DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();
        return view('admin.note', compact('data'));
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::table('notes')->insert([
            'note_date' => $request->note_date,
            'note_title' => $request->note_title,
            'note_detail' => $request->note_detail,
            // 'note_tags' => $request->note_tags,
            'note_tags' => implode( ',', $request->note_tags),
            'employee_id' => Auth::user()->id,
        ]);

        return back();
        // echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='note'; </script>");
    }

    public function edit($id)
    {
        $dataEdit = Note::join('master_note', 'notes.note_tags', 'master_note.id')
        ->where('notes.id', $id)->select('notes.*', 'master_note.name_tag')->first();

        $master_note = DB::table('master_note')->get();
        $data = array(
            'dataEdit'     => $dataEdit,
            'master_note'  => $master_note
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
            'note_tags' => implode( ',', $request->note_tags),
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

    public function search_month_note(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $data =  DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->whereDate('note_date', '>=', $from)
        ->whereDate('note_date', '<=', $to)
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();

        // return $list_approval;

        return view('saleman.note', compact('data'));
    }

    public function lead_search_month_note(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $data =  DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->whereDate('note_date', '>=', $from)
        ->whereDate('note_date', '<=', $to)
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();


        // return $list_approval;

        return view('leadManager.note', compact('data'));
    }

    public function head_search_month_note(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $data =  DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->whereDate('note_date', '>=', $from)
        ->whereDate('note_date', '<=', $to)
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();


        // return $list_approval;

        return view('headManager.note', compact('data'));
    }

    public function admin_search_month_note(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $data =  DB::table('notes')->join('master_note', 'notes.note_tags', 'master_note.id')
        ->whereDate('note_date', '>=', $from)
        ->whereDate('note_date', '<=', $to)
        ->where('notes.employee_id', Auth::user()->id)
        ->select('notes.*', 'master_note.name_tag')
        ->orderBy('notes.status_pin', 'desc')
        ->orderBy('notes.note_date', 'asc')->get();


        // return $list_approval;

        return view('admin.note', compact('data'));
    }
}
