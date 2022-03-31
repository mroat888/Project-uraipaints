<?php

namespace App\Http\Controllers\ShareData_Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportHistoricalMonthController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $year_old1 = $year-1;
        $year_old2 = $year-2;

        $data['search_year'] = array($year, $year_old1, $year_old2);
        $month_api = array();

        $path_search = "reports/years/".$year.",".$year_old1.",".$year_old2."/months/1,2,3,4,5,6,7,8,9,10,11,12";
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $res_api = $response->json();

        $sum_all = 0;
        $data['summary'] = array();
        $data['summary_present'] = array();
    
        foreach($data['search_year'] as $key_year => $value_year){
            $month = 1;
            $sum_netSales = 0;
            $sum_customers = 0;
            for($i=0; $i<12; $i++){
                foreach($res_api['data'] as $key => $value){
                    if(($value_year == $value['year']) && ($month == $value['month'])){
                        $data['month_api'][$key_year][$i] =[
                            'year' => $value['year'],
                            'month' => $value['month'],
                            'Sellers' => $value['Sellers'],
                            'customers' => $value['customers'],
                            'sales' => $value['sales'],
                            'credits' => $value['credits'],
                            'netSales' => $value['netSales'],
                            '%Credit' => $value['%Credit'],
                        ];
                        $sum_netSales += $value['netSales'];
                        $sum_customers += $value['customers'];
                    }
                }
                $month++;
            }

            $data['summary'][$key_year] = [
                'sum_netSales' => $sum_netSales,
                'sum_customers' => $sum_customers,
            ];

            $sum_all += $sum_netSales;

        }

        foreach($data['search_year'] as $key_year => $value_year){
            $present = ($data['summary'][$key_year]['sum_netSales']*100)/$sum_all;
            $data['summary_present'][$key_year] = $present;
        }


       // dd($month_api);

        return view('shareData_admin.report_historical_month', $data);
    }

    public function search(Request $request)
    {
        $data['search_year'] = array();

        if($request->sel_year_form >= $request->sel_year_to){
            $reage_year = $request->sel_year_form - $request->sel_year_to;
            $data['search_year'][] = $request->sel_year_to+0;
        }else{
            $reage_year = $request->sel_year_to - $request->sel_year_form;
            $data['search_year'][] = $request->sel_year_form+0;
        }

        $year_text = "";
        $search_year = "";

        if($reage_year >= 1){
            for($i=1; $i<$reage_year; $i++){
                if($request->sel_year_form >= $request->sel_year_to){
                    $year_text .= $request->sel_year_to+$i."," ;
                    $data['search_year'][] = $request->sel_year_to+$i;
                }else{
                    $year_text .= $request->sel_year_form+$i."," ;
                    $data['search_year'][] = $request->sel_year_form+$i;
                }

            }
            if($request->sel_year_form >= $request->sel_year_to){
                $search_year =  $request->sel_year_to.",".$year_text.$request->sel_year_form;
                $data['search_year'][] = $request->sel_year_form+0;
            }else{
                $search_year =  $request->sel_year_form.",".$year_text.$request->sel_year_to;
                $data['search_year'][] = $request->sel_year_to+0;
            }
        }else{
            $search_year =  $request->sel_year_form;
        }

        //$data['search_year'] = array($year, $year_old1, $year_old2);
        $month_api = array();

        $path_search = "reports/years/".$search_year."/months/1,2,3,4,5,6,7,8,9,10,11,12";
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $res_api = $response->json();

        $sum_all = 0;
        $data['summary'] = array();
        $data['summary_present'] = array();
    
        foreach($data['search_year'] as $key_year => $value_year){
            $month = 1;
            $sum_netSales = 0;
            $sum_customers = 0;
            for($i=0; $i<12; $i++){
                foreach($res_api['data'] as $key => $value){
                    if(($value_year == $value['year']) && ($month == $value['month'])){
                        $data['month_api'][$key_year][$i] =[
                            'year' => $value['year'],
                            'month' => $value['month'],
                            'Sellers' => $value['Sellers'],
                            'customers' => $value['customers'],
                            'sales' => $value['sales'],
                            'credits' => $value['credits'],
                            'netSales' => $value['netSales'],
                            '%Credit' => $value['%Credit'],
                        ];
                        $sum_netSales += $value['netSales'];
                        $sum_customers += $value['customers'];
                    }
                }
                $month++;
            }

            $data['summary'][$key_year] = [
                'sum_netSales' => $sum_netSales,
                'sum_customers' => $sum_customers,
            ];

            $sum_all += $sum_netSales;

        }

        foreach($data['search_year'] as $key_year => $value_year){
            $present = ($data['summary'][$key_year]['sum_netSales']*100)/$sum_all;
            $data['summary_present'][$key_year] = $present;
        }


       // dd($month_api);

        return view('shareData_admin.report_historical_month', $data);
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
