<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;

class SecurityController extends Controller
{

    public function sessions()
{
    return response()->json([
        'success' => true,
        'data' => auth()->user()->tokens()->latest()->get()
    ]);
}

public function logoutSession($id)
{
    auth()->user()->tokens()->where('id', $id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Session logged out'
    ]);
}



public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    if (!Hash::check($request->current_password, auth()->user()->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Current password is incorrect'
        ], 422);
    }

    auth()->user()->update([
        'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Password updated successfully'
    ]);
}
public function logoutAll()
{
    auth()->user()->tokens()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Logged out from all devices'
    ]);
}
public function deleteAccount(Request $request)
{
    $request->validate([
        'password' => 'required'
    ]);

    if (!Hash::check($request->password, auth()->user()->password)) {
        return response()->json(['success' => false], 403);
    }

    auth()->user()->tokens()->delete();
    auth()->user()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Account deleted'
    ]);
}


}
