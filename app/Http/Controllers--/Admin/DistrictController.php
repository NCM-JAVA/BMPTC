<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\State;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $states = State::orderBy('state_name', 'ASC')->get();
        $data = District::select('districts.*', 'states.state_name')
            ->join('states', 'districts.state_id', '=', 'states.id');

        if ($request->search) {
            $search = $request->search;
            $data->where(function ($q) use ($search) {
                $q->where('districts.district_name', 'like', "%$search%")
                    ->orWhere('states.state_name', 'like', "%$search%");
            });
        }

        if ($request->filled('state_id')) {
            $data->where('districts.state_id', $request->state_id);
        }

        if ($request->status) {
            $data->where('districts.status', $request->status);
        }

        $data = $data->orderBy('districts.state_id', 'ASC')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.district.index', compact('data', 'states'));
    }

    public function create()
    {
        $data = State::select('id', 'state_name')->get();
        return view('admin.district.add', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'district_name' => 'required|string|max:255',
            'district_code' => 'required|string|max:255',
            'state_id' => 'required',
            'status' => 'required|in:1,2,3',
            'coordinates' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'dist_pdf' => 'nullable|mimes:pdf|max:5120'
        ]);

        $data = new District();
        $data->district_name = $request->district_name;
		$data->state_id = $request->state_id;
        $data->district_code = $request->district_code;
        $data->status = $request->status;
        $data->coordinates = $request->coordinates;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/img/district');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);

            $data->image = $imageName;
            $data->image_date = Carbon::now();
        }

        if ($request->hasFile('dist_pdf')) {
            $dist_pdf = $request->file('dist_pdf');
            $pdfName = time() . '_' . $dist_pdf->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/pdf/district');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $dist_pdf->move($destinationPath, $pdfName);

            $data->dist_pdf = $pdfName;
        }

        $data->save();

        return redirect()->route('admin.manage-district.index')->with('success', 'District added successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = District::where('id', $id)
            ->first();

        return view('admin.district.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = District::findOrFail($id);

        $request->validate([
            'district_name' => 'required|string|max:255',
            'status' => 'required|in:1,2,3',
            'coordinates' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'dist_pdf' => 'nullable|mimes:pdf|max:5120'
        ]);

        $data->district_name = $request->district_name;
        $data->status = $request->status;
        $data->coordinates = $request->coordinates;
        $data->image_date = Carbon::now();

        if ($request->hasFile('image')) {
            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/img/district');
            $image->move($destinationPath, $imageName);

            $data->image = $imageName;
        }

        if ($request->hasFile('dist_pdf')) {
            $dist_pdf = $request->file('dist_pdf');
            $pdfName = time() . '_' . $dist_pdf->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/pdf/district');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $dist_pdf->move($destinationPath, $pdfName);

            $data->dist_pdf = $pdfName;
        }


        $data->save();

        return redirect()->route('admin.manage-district.index')->with('success', 'District updated successfully.');
    }

    public function destroy($id)
    {
        //
    }
}
