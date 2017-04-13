<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest', ['except' => 'logout']);
    }

    public function commonLogin(Request $request)
    {
        $roles = ['username' => 'required|min:5|max:16', 'password' => 'required|min:5|max:32'];
        $message = [
            'required' => '请输入邮箱及密码！',
            'username.min' => '密码长度最低为5位',
            'username.max' => '密码长度最低为16位',
            'password.min' => '密码长度最低为5位',
            'password.max' => '密码长度最低为32位',
        ];
        $this -> validate($request, $roles, $message);
        if((Auth::attempt(['username' => $request -> username, 'password' => $request -> password]))) {
            return redirect() -> back();
        } else {
            return redirect() -> back() -> with('error', '登陆失败！邮箱或密码错误！');
        }
    }


    public function commonLogout()
    {
        $this->guard()->logout();
        return redirect() -> back();
    }

    public function redirectToProvider(Request $request, $service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function handleProviderCallback(Request $request, $service)
    {
        $user = Socialite::driver($service)->user();
        switch ($service) {
            case 'github':
                $userInfo = $this -> githubCallback($user);
                break;
            case 'qq':
                break;
            case 'weibo':
                break;
            case 'weixin':
                break;
            default:
                break;
        }
        $this -> login();
        return view('frontend/register');

    }

    private function githubCallback($user)
    {
        # TODO 第三方授权表中，检查该用户是否有关联的账户，如果有，则直接登陆，如果没有，则进行绑定！
    }

    private function login($username = '123')
    {
        # TODO 用户登陆
    }
}
