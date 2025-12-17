<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class StateController extends Controller
{
    public function index()
    {
        $data = State::where('status', 3)
            ->orderBy('state_name', 'ASC')
            ->paginate(10);

        return view('admin.state.index', compact('data'));
    }

    public function create()
    {
        return view('admin.state.add');
    }

    public function store(Request $request)
    {
         $request->validate([
            'state_name'  => 'required|string|max:255',
            'status'      => 'required|in:1,2,3',
            'coordinates' => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $state = new State();
        $state->state_name  = $request->state_name;
        $state->state_code  = $request->state_code;
        $state->status      = $request->status;
        $state->coordinates = $request->coordinates;

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/img/uploads/state');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);

            $state->image = $imageName;
            $state->image_date = Carbon::now();
        }

        $state->save();

        return redirect()->route('admin.manage-state.index')->with('success', 'State added successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = State::where('id', $id)
            ->first();

        return view('admin.state.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = State::findOrFail($id);

        $request->validate([
            'state_name' => 'required|string|max:255',
            'status' => 'required|in:1,2,3',
            'coordinates' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data->state_name = $request->state_name;
        $data->status = $request->status;
        $data->coordinates = $request->coordinates;
        $data->image_date = Carbon::now();

        if ($request->hasFile('image')) {
            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/img/uploads/state');
            $image->move($destinationPath, $imageName);

            $data->image = $imageName;
        }

        $data->save();

        return redirect()->route('admin.manage-state.index')->with('success', 'State updated successfully.');
    }

    public function destroy($id)
    {
        //
    }
}
