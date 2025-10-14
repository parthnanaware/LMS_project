<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class studentController extends Controller
{
public function index()
{
    $data = User::where('role', 'student')->get();
    return view('student.index', compact('data'));
}


    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $photoName = null;
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $photoName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/profiles'), $photoName);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'photo' => $photoName,
        ]);

        return redirect()->route('student.index')->with('success', 'Student created successfully!');
    }

    public function edit(User $student)
    {
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $photoName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/profiles'), $photoName);
            $student->photo = $photoName;
        }

        $student->name = $request->name;

        $student->email = $request->email;

        $student->role = $request->role;
        if ($request->password) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('student.index')->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();
        return redirect()->route('student.index')->with('success', 'Student deleted successfully!');
    }
         public function showProfile()
    {
        $user = Auth::user();

        return view('pages.profile', compact('user'));
    }
}
