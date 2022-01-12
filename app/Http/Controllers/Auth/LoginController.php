<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    // public function login(Request $request){
    //     $input = $request->all();

    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' =>'required'
    //     ]);

    //     if (auth()->attempt((array('email' => $input['email'], 'password' => $input['password'])))) {
    //         if (auth()->user()->status == 0) {
    //             return redirect('dashboard');
    //         }elseif (auth()->user()->status == 1) {
    //             return redirect('leadManager');
    //         }elseif (auth()->user()->status == 2) {
    //             return redirect('headManage');
    //         }elseif (auth()->user()->status == 3){
    //             return redirect('admin');
    //         }else{
    //             return back()->with('error', 'ไม่มีอีเมล์นี้อยู่ในระบบ!');
    //         }
    //     }else{
    //         return back()->with('error', 'อีเมล์หรือรหัสผ่านไม่ถูกต้อง!');
    //     }

    // }
}
