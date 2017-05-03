<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $this->middleware('guest', ['except' => ['logout', 'bindConfirm']]);
    }

    public function commonLogin(Request $request)
    {
        $roles = ['username' => 'required|min:5|max:16', 'password' => 'required|min:5|max:32'];
        $message = [
            'required' => '请输入用户名及密码！',
            'username.min' => '用户名长度最低为5位',
            'username.max' => '用户名长度最低为16位',
            'password.min' => '密码长度最低为5位',
            'password.max' => '密码长度最低为32位',
        ];
        $this -> validate($request, $roles, $message);
        if((Auth::attempt(['username' => $request -> username, 'password' => $request -> password]))) {
            return redirect() -> back();
        } else {
            return $this -> sendFailedLoginResponse($request) -> with('error', '登陆失败！用户名或密码错误！');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/') -> with('success', '您已退出登录！');
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
            case 'weixin':
                $userInfo = $this -> isExistOauthUser($user, 3);
                break;
            case 'qq':
                $userInfo = $this -> isExistOauthUser($user, 4);
                break;
            default:
                abort(404);
                $userInfo = null;
                break;
        }
        if (is_null($userInfo)) {
            $data = [
                'source' => $service,
                'oId' => $user -> id,
                'name' => $user -> name,
                'avatar' => $user -> avatar,
                'email' => $user -> email,
            ];
            $param = encrypt(json_encode($data));
            return redirect('/user/bind?p=' . $param);
        } else {
            Auth::attempt(['id' => $userInfo -> uId, 'password' => $service . '-' . $userInfo -> oId]);
            return view('login');
        }
    }

    private function isExistOauthUser($user, $source = 0)
    {
        return DB::table('oauth')
            -> select('uId', 'oId')
            -> where('isDelete', 0)
            -> where('oId', $user -> id)
            -> where('source', $source)
            -> first();
    }

    public function userBind(Request $request)
    {
        $email = '';
        $nickname = '';
        $name = '';
        $avatar = '';
        $source = '';
        $oId = '';
        if ($request -> has('p')) {
            try {
                $param = json_decode(decrypt($request -> p), true);
                $email = $param['email'];
                $name = $param['name'];
                $avatar = $param['avatar'];
                $source = $param['source'];
                $oId = $param['oId'];
            } catch (\Exception $e) {
                Log::warning($e -> getMessage());
            }
            return view('frontend.bind.form', [
                'email' => $email, 'nickname' => $nickname, 'name' => $name,
                'avatar' => $avatar, 'source' => $source, 'oId' => $oId
            ]);
        } else {
            return redirect('/') -> with('error', '请求异常，请重新登陆');
        }
    }

    public function storeUserBind(Request $request)
    {
        $roles = [
            'email' => 'required|email',
            'name' => 'required|min:1|max:255',
            'avatar' => 'required|min:1|max:255',
            'source' => 'required|in:github,weibo,weixin,qq',
            'oId' => 'required|min:1|max:255'
        ];
        $this -> validate($request, $roles);
        $data = $request -> except(['_token', '_url']);
        $param = json_encode($data);
        $id = str_replace('.', '',uniqid('', true));
        Cache::add($id, $param, env('BIND_CONFIRMATION_EXPIRED_IN'));
        $data = [
            'email' => $request -> email,
            'name' => $request -> name,
            'source' => $request -> source,
            'id' => encrypt($id)
        ];
        dispatch((new SendMailJob($request -> email, $data)) -> onQueue('SendMail'));
        return view('frontend.bind.response', ['email' => $request -> email, 'name' => $request -> name]);
    }

    public function bindConfirm($token = '')
    {
        try {
            $id = decrypt($token);
            $json = Cache::get($id);
            if (is_null($json)) {
                return view('frontend.bind.confirmation',
                    ['message' => '绑定失败，您的链接已经失效，请重新绑定！正在跳回主页，如无法跳转，请<a href="/">点击这里</a>！']);
            } else {
                $data = json_decode($json);
                $user = DB::table('users')
                    -> select('id', 'username') -> where('email', $data -> email) -> where('isDelete', 0) -> first();
                if (is_null($user)) {
                    $username = $data -> source . '-' . $data -> oId;
                    $userInfo = [
                        'username' => $username,
                        'password' => bcrypt($username),
                        'email' => $data -> email,
                        'name' => $data -> name,
                        'avatar' => $data -> avatar,
                        'roleId' => 999,
                    ];
                    $pKey = DB::table('users')
                        -> insertGetId($userInfo);

                } else {
                    $pKey = $user -> id;
                    $username = $user -> username;
                }
                DB::table('oauth')
                    -> insert([
                        'oId' => $data -> oId, 'uId' => $pKey, 'source' => $this -> getOauthSourceCode($data -> source)
                    ]);
                Auth::attempt(['id' => $pKey, 'password' => $username]);
                Cache::forget($id);
                return view('frontend.bind.confirmation',
                    ['message' => '绑定邮箱成功，正在跳转到主页！如无法跳转，请<a href="/">点击这里</a>！']);
            }
        } catch (\Exception $e) {
            Log::warning('用户绑定确认失败，错误原因：' . $e -> getMessage());
            return view('frontend.bind.confirmation',
                ['message' => '系统异常，请稍后再试！正在跳回主页，如无法跳转，请<a href="/">点击这里</a>！']);
        }
    }

    private function getOauthSourceCode($source = '')
    {
        switch ($source) {
            case 'github':
                return 1;
                break;
            case 'weibo':
                return 2;
                break;
            case 'weixin':
                return 3;
                break;
            case 'qq':
                return 4;
                break;
            default:
                abort(404);
                return 0;
                break;
        }
    }
}
