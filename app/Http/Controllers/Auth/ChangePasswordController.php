<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('auth.passwords.change-password');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $user = Auth::user();
            if (!$user || !Hash::check($request->input('current_password'), $user->password)) {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            }
        });

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)   
                ->withInput();
        }

        $user = Auth::user();
        $user->password = Hash::make($request->input('new_password'));
        $user->save();
        
        return back()->with('success', 'Password updated successfully!');
    }
}
