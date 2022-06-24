<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\AlphaNumHalf;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', "max:32", new AlphaNumHalf, 'confirmed'],
        ]);
    }


    protected function create(array $data)
    {
        if (!User::where("email", $data["email"])->exists()) {
            $user = User::create([
                'user_id' => $data["user_id"],
                'name' => $data['name'],
                'email' => $data["email"],
                'password' => Hash::make($data['password']),
                'email_verify_token' => base64_encode($data['email']),
            ]);
        } else {
            $user = User::where("email", $data["email"])->first();
        }

        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
    }

    public function pre_check(Request $request)
    {
        $this->validator($request->all())->validate();

        $request->session()->put("user_id", $request->input("user_id"));
        $request->session()->put("name", $request->input("name"));
        $request->session()->put("email", $request->input("email"));
        $request->session()->put("password", $request->input("password"));

        $password_mask = str_repeat("*", strlen($request->input("password")));
        return view('auth.check_register', compact("password_mask"));
    }

    public function pre_complete()
    {
        return view("auth.temp_register");
    }

    public function register(Request $request)
    {
        event(new Registered($this->create($request->session()->all())));
        return redirect('/register/pre_complete')->with("flash_message", "仮登録メールを送信しました。");
    }

    public function showForm($email_token)
    {
        if (!User::where('email_verify_token', $email_token)->exists()) {
            return view('auth.login')->with('message', '無効なトークンです。');
        } else {
            $user = User::where('email_verify_token', $email_token)->first();
            if ($user->status == config('const.USER_STATUS.REGISTER')) //REGISTER=1
            {
                logger("status" . $user->status);
                return view('auth.login')->with('message', 'すでに本登録されています。ログインして利用してください。');
            }
            $user->status = config('const.USER_STATUS.MAIL_AUTHED');
            $user->email_verified_at = Carbon::now();
            if ($user->save()) {
                Auth::login($user);
                return view('auth.complete_register', compact('email_token'));
            } else {
                return view('auth.login')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }
}
