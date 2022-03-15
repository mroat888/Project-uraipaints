<?php

namespace App\Http\Controllers\ShareData_HeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportHistoricalQuarterController extends Controller
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

        $path_search = "reports/years/".$year.",".$year_old1.",".$year_old2."/quaters/1,2,3,4/headers/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $quarter_api = $response->json();

        $data['year_search'] = array($year, $year_old1, $year_old2);
        $search_year = $year.",".$year_old1.",".$year_old2;

        $data['sum_present'] = array();
        $data['total_year'] = array();

        $data['sum_netSales_q1'] = 0;
        $data['sum_netSales_q2'] = 0;
        $data['sum_netSales_q3'] = 0;
        $data['sum_netSales_q4'] = 0;

        // Chat
        $data_year = "";

        if($quarter_api['code'] == 200){

            foreach($data['year_search'] as $key_year => $year_search ){
                $total_year = 0;
                

                foreach($quarter_api['data'] as $key => $value){
                    
                    if($value['year'] == $year_search){

                        switch ($value['quater']) {
                            case 1:
                                $data['quarter_api_year'][$key_year]['q1'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q1'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 2:
                                $data['quarter_api_year'][$key_year]['q2'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q2'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 3:
                                $data['quarter_api_year'][$key_year]['q3'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q3'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 4:
                                $data['quarter_api_year'][$key_year]['q4'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q4'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                        }
                        
                    }

                }
                
                $data['total_year'][] = [
                    'total_year' => $total_year,
                ];
            }
        }

        //dd($data['sum_netSales_q1'], $data['sum_netSales_q2'], $data['sum_netSales_q3'], $data['sum_netSales_q4']);

        // Chat
        $data['search_year'] = $search_year;

        //dd($data['total_year']);

        

        return view('shareData_headManager.report_historical_quarter', $data);
    }

    public function search(Request $request){
        $data['year_search'] = array();

        if($request->sel_year_form >= $request->sel_year_to){
            $reage_year = $request->sel_year_form - $request->sel_year_to;
            $data['year_search'][] = $request->sel_year_to+0;
        }else{
            $reage_year = $request->sel_year_to - $request->sel_year_form;
            $data['year_search'][] = $request->sel_year_form+0;
        }
        $year_text = "";
        $search_year = "";
        
        if($reage_year >= 1){
            for($i=1; $i<$reage_year; $i++){
                if($request->sel_year_form >= $request->sel_year_to){
                    $year_text .= $request->sel_year_to+$i."," ;
                    $data['year_search'][] = $request->sel_year_to+$i;
                }else{
                    $year_text .= $request->sel_year_form+$i."," ;
                    $data['year_search'][] = $request->sel_year_form+$i;
                }

            }
            if($request->sel_year_form >= $request->sel_year_to){
                $search_year =  $request->sel_year_to.",".$year_text.$request->sel_year_form;
                $data['year_search'][] = $request->sel_year_form+0;
            }else{
                $search_year =  $request->sel_year_form.",".$year_text.$request->sel_year_to;
                $data['year_search'][] = $request->sel_year_to+0;
            }
        }else{
            $search_year =  $request->sel_year_form;
        }

        $path_search = "reports/years/".$search_year."/quaters/1,2,3,4/headers/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $quarter_api = $response->json();

        $data['sum_present'] = array();
        $data['total_year'] = array();

        $data['sum_netSales_q1'] = 0;
        $data['sum_netSales_q2'] = 0;
        $data['sum_netSales_q3'] = 0;
        $data['sum_netSales_q4'] = 0;

        if($quarter_api['code'] == 200){

            foreach($data['year_search'] as $key_year => $year_search ){
                $total_year = 0;
                

                foreach($quarter_api['data'] as $key => $value){
                    
                    if($value['year'] == $year_search){

                        switch ($value['quater']) {
                            case 1:
                                $data['quarter_api_year'][$key_year]['q1'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q1'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 2:
                                $data['quarter_api_year'][$key_year]['q2'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q2'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 3:
                                $data['quarter_api_year'][$key_year]['q3'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q3'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 4:
                                $data['quarter_api_year'][$key_year]['q4'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $data['sum_netSales_q4'] += $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                        }
                        
                    }

                }
                
                $data['total_year'][] = [
                    'total_year' => $total_year,
                ];
            }
        }

        // Chat
        $data['search_year'] = $search_year;

        // dd($data['total_year']);

        return view('shareData_headManager.report_historical_quarter', $data);
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
