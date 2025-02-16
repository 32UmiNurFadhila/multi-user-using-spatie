<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return $this->authenticated($request, auth()->user());
        }

        return redirect()->back()->withErrors(trans('auth.login_failed'))->withInput();
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        $role = $user->roles->pluck('name')[0];

        switch ($role) {
            case "customer":
                return redirect()->intended(RouteServiceProvider::CUSTOMER)->with('success', 'Berhasil login!');
            case "admin":
                return redirect()->intended(RouteServiceProvider::ADMIN)->with('success', 'Berhasil login!');
            default:
                return redirect()->back()->withErrors("Ada yang salah");
        }
    }
}