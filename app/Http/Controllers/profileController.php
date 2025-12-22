<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

// GET /api/profile
public function apiShowProfile(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'photo_url' => $user->photo
                ? url('storage/profiles/' . $user->photo)
                : null,
        ]
    ], 200);
}
// POST /api/profile
public function apiUpdateProfile(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    $request->validate([
        'name' => 'nullable|string|max:255',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    // Name Update
    if ($request->name) {
        $user->name = $request->name;
    }

    // Photo Upload
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $photoName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/profiles'), $photoName);

        $user->photo = $photoName;
    }

    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Profile updated successfully!',
        'data' => [
            'name' => $user->name,
            'photo_url' => $user->photo
                ? url('storage/profiles/' . $user->photo)
                : null,
        ]
    ], 200);
}


}
