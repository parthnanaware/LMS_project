<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
        'role' => 'string|in:admin,student',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();

        if ($user->status === 1) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Your account is inactive.');
        }

        if ($user->role === 'admin') {
            return redirect()->intended('/');
        } elseif ($user->role === 'student') {
            return redirect()->intended('/sd');
        }

    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}





}
