<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view(){
        return view('admin.profile.index');
    }
	
	public function editprofile(){
        $user =Auth::user();
        return view('admin.user.editprofile', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|integer',
        'status' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->status = $request->status;

 if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('assets/uploads/profile_images/');

       
        $image->move($path, $filename);
        $user->image = $filename;
    }

    $user->save();

    $request->session()->put([
        'user_name' => $user->name,
        'user_email' => $user->email,
        'user_role' => $user->role,
        'user_status' => $user->status,
    ]);

    return redirect()->route('admin.editprofile', $user->id)
        ->with('success', 'Profile updated successfully!');
}
}
