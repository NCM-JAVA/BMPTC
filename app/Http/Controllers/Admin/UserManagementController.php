<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
     public function index(){
        $user = User::all();
        return view('admin.user.index',compact('user'));
    }

    public function create(){
        return view('admin.user.add');
    }

   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'   => 'required|string|max:255',
        'email'  => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role'   => 'required|integer',
        'status' => 'required|integer',
        'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    $user = new User();
    $user->name   = $request->name;
    $user->email  = $request->email;
    $user->role   = $request->role;
    $user->status = $request->status;

    $user->password = Hash::make($request->password);

  if ($request->hasFile('image')) {
    $file = $request->file('image');
    $fileName = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('assets/uploads/profile_images', $fileName, 'public');
    $user->image = $fileName;
}


    $user->save();

    return redirect()->route('admin.manage-user.index')
                     ->with('success', 'User created successfully!');
}

public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.user.edit', compact('user'));
}

 public function update(Request $request,$id)
{
    $validator = Validator::make($request->all(), [
        'name'   => 'required|string|max:255',
        'email'  => 'required|email',
        'role'   => 'required|integer',
        'status' => 'required|integer',
        'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

   $user = User::findOrFail($id);
    $user->name   = $request->name;
    $user->email  = $request->email;
    $user->role   = $request->role;
    $user->status = $request->status;

    

   //if ($request->hasFile('image')) {
    //$file = $request->file('image');
   // $fileName = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
   // $filePath = $file->storeAs('assets/uploads/profile_images', $fileName, 'public');
   // $user->image = $filePath;
//}
if ($request->hasFile('image')) {
    $file = $request->file('image');
    $fileName = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();

    // Store the file in the folder, but do not save the folder path in DB
    $file->storeAs('assets/uploads/profile_images', $fileName, 'public');

    // Save only the file name (not the path)
    $user->image = $fileName;
}




    $user->save();

    return redirect()->route('admin.manage-user.index')
                     ->with('success', 'User created successfully!');
}
public function destroy($id){
$user = User::findOrFail($id);
$user->delete();
return redirect()->route('admin.manage-user.index')->with('success', 'User deleted successfully.');
}

}
