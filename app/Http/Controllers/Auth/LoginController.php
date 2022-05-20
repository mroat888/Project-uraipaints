<?php

namespace App\Http\Controllers\Auth;

use App\Event;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\News;
use App\Providers\RouteServiceProvider;
use App\UsageHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_token = new ApiController();
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' =>'required'
        ]);


        if (auth()->attempt((array('email' => $input['email'], 'password' => $input['password'])))) {

            $list_promotion = News::where('status', "P")->get();
            foreach ($list_promotion as $key => $value) {
                if ($value->news_date <= Carbon::today()->format('Y-m-d') && $value->news_date_last < Carbon::today()->format('Y-m-d'))
                {
                    $data2 = News::find($value->id);
                    $data2->status_promotion  = 0;
                    $data2->updated_at        = Carbon::now();
                    $data2->update();

                }
            }

            UsageHistory::create([
                'date' => Carbon::now(),
                'emp_id' => Auth::user()->id,
            ]);

            $api_token = $this->api_token->apiToken();
            $data['api_token'] = $api_token;

            $path_search = env("API_LINK").env("API_PATH_VER").'/bdates/sellers/'.Auth::user()->api_identify.'/customers';
            $api_token = $this->api_token->apiToken();
            $response = Http::withToken($api_token)->get($path_search);
            $res_api = $response->json();

            if(!is_null($res_api['data'])) {
                foreach ($res_api['data'] as $value) {
                    $chkEvent = DB::table('events')->where('identify', $value['identify'])->first();

                    if ($chkEvent) {
                        $date = Carbon::parse($chkEvent->start);
                    if ($date->format('Y-m-d') != $value['focusDate']) {
                        DB::table('events')
                        ->insert([
                            'title' => $value['descripDate'],
                            'start' => $value['focusDate'],
                            'end' => $value['focusDate'],
                            'identify' => $value['identify'],
                            'created_by' => Auth::user()->id
                        ]);
                    }
                    }else{
                        DB::table('events')
                        ->insert([
                            'title' => $value['descripDate'],
                            'start' => $value['focusDate'],
                            'end' => $value['focusDate'],
                            'identify' => $value['identify'],
                            'created_by' => Auth::user()->id
                        ]);
                    }

            }
        }

            if (auth()->user()->status == 1) {
                return redirect('dashboard');
            }elseif (auth()->user()->status == 2) {
                return redirect('lead/dashboard');
            }elseif (auth()->user()->status == 3) {
                return redirect('headManage');
            }elseif (auth()->user()->status == 4){
                return redirect('admin');
            }else{
                return back()->with('error', 'ไม่มีอีเมล์นี้อยู่ในระบบ!');
            }
        }else{
             return back()->with('error', 'อีเมล์หรือรหัสผ่านไม่ถูกต้อง!');
        }

    }
}
