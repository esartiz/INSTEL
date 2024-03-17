<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User_log;
use Request;

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
    public function redirectTo()
    {
        //Save the session data
        $datosLog['user'] = Auth::user()->id;
        $datosLog['ip'] = Request::ip();
        $datosLog['fecha'] = date('Y-m-d H:i:s');
        $nt = User_log::create($datosLog);
    } 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('guest')->except('logout');
    }
}
