<?php

namespace App\Http\Controllers\ShareData_Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportHistoricalYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $year = $year+0;
        $year_old1 = $year-1; 
        $year_old2 = $year-2;
     
        $path_search = "reports/years/".$year.",".$year_old1.",".$year_old2;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search);
        $year_api = $response->json();
        
        if($year_api['code'] == 200){
            $sum_sales = 0;
            $sum_credits = 0;
            $sum_netSales = 0;
            $sum_persent_credits =0 ;
            $persent_sale =0 ;
            $chat_customer = "";
            $chat_netsales = "";
            $chat_year = "";
            foreach($year_api['data'] as $value){
                $sum_sales += $value['sales'];
                $sum_credits += $value['credits'];
                $sum_netSales += $value['netSales'];
            }

            $count_row = count($year_api['data']); // นับจำนวน array
            $crow = 1;
            foreach($year_api['data'] as $value){
                $persent_sale =  ($value['netSales'] * 100 ) / $sum_netSales;
                $yearadmin_api[] = [
                    'year' => $value['year'],
                    'customers' => $value['customers'],
                    'Sellers' => $value['Sellers'],
                    'months' => $value['months'],
                    'sales' => $value['sales'],
                    'credits' => $value['credits'],
                    '%Credit' => $value['%Credit'],
                    'netSales' => $value['netSales'],
                    '%Sale' => $persent_sale,
                ];

                // -- Caht data
                if($crow != $count_row){
                    if(!is_null($value['customers'])){
                        $chat_customer .= $value['customers'].",";
                        $chat_netsales .= $value['netSales'].",";
                    }else{
                        $chat_customer .= "0,";
                        $chat_netsales .= "0,";
                    }
                }else{
                    if(!is_null($value['customers'])){
                        $chat_customer .= $value['customers'];
                        $chat_netsales .= $value['netSales'];
                    }else{
                        $chat_customer .= "0";
                        $chat_netsales .= "0";
                    }
                }
                // -- Caht data

            }

            $sum_persent_credits = ($sum_credits * 100)/$sum_sales;

            $summary_yearadmin_api = [
                'sum_sales' => $sum_sales,
                'sum_credits' => $sum_credits,
                'sum_persent_credits' => $sum_persent_credits,
                'sum_netSales' => $sum_netSales,
            ];

            // -- Chat
            $chat_year = $year_old2.",".$year_old1.",".$year;

        }

        return view('shareData_admin.report_historical_year', compact('yearadmin_api', 'summary_yearadmin_api', 'chat_year', 'chat_customer', 'chat_netsales'));
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
