<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{

    public function index()
    {
        $managers = DB::table('users')->get();
        return view('admin.add_assignment', compact('managers'));
    }

    public function searchselect(Request $request)
    {
        if ($request->ajax()) {

            // $knowledges = DB::table('users')->orderBy('id', 'desc')->get();
            $teams = DB::table('users')->where('team_id', $request->visit_result_status)->orderBy('id', 'desc')->get();
            // $url = 'public/upload/Knowledge/';
            $output = '';

            if ($request->visit_result_status == '') {
                $output .= '<button type="submit" class="btn btn-primary">บันทึก</button>';
            }else{
                foreach ($teams as $value) {

                    $output .=
                    '
                        <option value="'.$value->id .'">'.$value->name.'</option>
               ';
            }
        }
            return $output;
        }
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
