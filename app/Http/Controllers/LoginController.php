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
        $email = null;
        switch ($service) {
            case 'github':
                $userInfo = $this -> isExistOauthUser($user, 1);
                break;
            case 'weibo':
                $userInfo = $this -> isExistOauthUser($user, 2);
                break;
            case 'qq':
                $userInfo = $this -> isExistOauthUser($user, 3);
                break;
            case 'weixin':
                $userInfo = $this -> isExistOauthUser($user, 4);
                break;
            default:
                abort(404);
                $userInfo = null;
                break;
        }
        if (is_null($userInfo)) {
            $data = [
                'u-source' => $service,
                'u-nickname' => $user -> nickname,
                'u-avatar' => $user -> avatar,
                'u-email' => $user -> email,
            ];
            return redirect('/user/bind') -> with($data);
        } else {
            Auth::attempt(['id' => $userInfo -> uId]);
            return view('login');
        }
    }

    private function isExistOauthUser($user, $source = 0)
    {
        return DB::table('oauth')
            -> select('uId')
            -> where('isDelete', 0)
            -> where('oId', $user -> id)
            -> where('source', $source)
            -> first();
    }

    public function bindEmailAddress(Request $request)
    {
        # TODO 将
    }
}
