<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UsageHistory;
use Illuminate\Http\Request;

class UsageHistoryController extends Controller
{

    public function index()
    {
        $history = UsageHistory::join('users', 'usage_history.emp_id', 'users.id')
        ->join('master_permission', 'users.status', 'master_permission.id')
        ->select('usage_history.date', 'users.name', 'users.email', 'master_permission.permission_name')
        ->orderBy('usage_history.id', 'desc')->get();

        return view('admin.check_history', compact('history'));
    }

    public function search(Request $request)
    {

        // dd($request);

        // $from = $request->fromMonth."-01";
        // $to = $request->toMonth."-31";
        // return $to;
        $history = UsageHistory::join('users', 'usage_history.emp_id', 'users.id')
        ->join('master_permission', 'users.status', 'master_permission.id')
        ->whereDate('usage_history.date', '>=', $request->fromMonth)
        ->whereDate('usage_history.date', '<=', $request->toMonth)
        ->select('usage_history.date', 'users.name', 'users.email', 'master_permission.permission_name')
        ->orderBy('usage_history.id', 'desc')->get();

        return view('admin.check_history', compact('history'));
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
