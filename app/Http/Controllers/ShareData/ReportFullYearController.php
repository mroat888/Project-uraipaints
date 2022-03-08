<?php

namespace App\Http\Controllers\ShareData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportFullYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $path_search = "reports/years/".$year."/sellers/search?sortorder=DESC&seller_id=".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search);
        $yearseller_api = $response->json();

        // สินค้า Top Group
        $path_search_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdgroups?sortorder=DESC&limits=10"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search_top);
        $grouptop_api = $response->json();

        // สินค้า Top SubGroup
        $path_search_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdsubgroups?sortorder=DESC&limits=10"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search_top);
        $subgrouptop_api = $response->json();

        // สินค้า Top Product List
        $path_search_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdlists?sortorder=DESC&limits=10"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search_top);
        $pdlisttop_api = $response->json();

        // dd($path_search_top);

        return view('shareData.report_full_year', compact('yearseller_api', 'grouptop_api', 'subgrouptop_api', 'pdlisttop_api'));
    }

    public function search(Request $request){

        $path_search = "reports/years/".$request->sel_year."/sellers/search?sortorder=DESC&seller_id=".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search);
        $yearseller_api = $response->json();

        // สินค้า Top Group
        $path_search_top = "reports/years/".$request->sel_year."/sellers/".Auth::user()->api_identify."/pdgroups?sortorder=DESC&limits=10"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search_top);
        $subgrouptop_api = $response->json();

        // สินค้า Top SubGroup
        $path_search_top = "reports/years/".$request->sel_year."/sellers/".Auth::user()->api_identify."/pdsubgroups?sortorder=DESC&limits=10"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search_top);
        $subgrouptop_api = $response->json();

        // สินค้า Top Product List
        $path_search_top = "reports/years/".$request->sel_year."/sellers/".Auth::user()->api_identify."/pdlists?sortorder=DESC&limits=10"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search_top);
        $pdlisttop_api = $response->json();

        return view('shareData.report_full_year', compact('yearseller_api', 'grouptop_api', 'subgrouptop_api', 'pdlisttop_api'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
