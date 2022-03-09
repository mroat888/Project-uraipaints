<?php

namespace App\Http\Controllers\LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Http;

class ReportTeamController extends Controller
{
    public function __construct(){
        $this->apicontroller = new ApiController();
    }

    public function index(){
        // $data['users'] = DB::table('users')->where('team_id',Auth::user()->team_id)->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $users = DB::table('users')
            ->whereIn('status', [1,2])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();
        //dd($auth_team, $users);

        $api_token = $this->apicontroller->apiToken(); 
        $data['users_api'] = array();
        foreach($users as $key => $value){
            $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/sellers/'.$value->api_identify.'/customers');
            $res_api = $response->json();

            $data['users_api'][$key] =
            [
                'id' => $value->id,
                'name' => $value->name,
                'count_shop' => $res_api['records'],
            ];
        }
        // dd($data['users_api']);
        return view('reports.report_team', $data);
    }
}
