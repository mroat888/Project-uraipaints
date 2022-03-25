<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\News;
use App\Providers\RouteServiceProvider;
use App\UsageHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' =>'required'
        ]);


        if (auth()->attempt((array('email' => $input['email'], 'password' => $input['password'])))) {
            // DB::beginTransaction();
            // try {
            //     $user_id = auth()->user()->id;
            //     DB::table('users')
            //     ->where('id', $user_id)
            //     ->update([
            //         'api_token' => '123456'
            //     ]);
            //     DB::commit();
            // } catch (\Exception $e) {

            //     DB::rollback();
            // }
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
