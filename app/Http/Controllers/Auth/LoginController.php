<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Web login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'string|in:admin,student',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->status === 0) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is inactive.');
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

    // API login for students
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Find user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }

        // Only allow students
        if ($user->role !== 'student') {
            return response()->json([
                'message' => 'Access denied. Only students can log in.'
            ], 403);
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }

        // Check account status
        if ($user->status == false) {
            return response()->json([
                'message' => 'Your account is inactive.'
            ], 403);
        }

        try {
           $token = $user->createToken('student-token')->plainTextToken;

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Token creation failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status,
            ]
        ], 200);
    }

    // API logout for students
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    }
}
