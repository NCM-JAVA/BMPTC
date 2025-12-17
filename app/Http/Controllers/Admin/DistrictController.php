<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\district_coordinate;
use DB;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\State;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $states = State::where('status', 3)->orderBy('state_name', 'ASC')->get();
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

        $data = $data->orderBy('districts.district_name', 'ASC')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.district.index', compact('data', 'states'));
    }

    public function create()
    {
        $data = State::select('id', 'state_name')->get();

        $hazard_zone = DB::table('districts_zone')->get();
        $map_shape = DB::table('map_shapes')->get();

        return view('admin.district.add', compact('data', 'hazard_zone', 'map_shape'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'district_name' => 'required|string|max:255',
            'district_code' => 'required|string|max:255',
            'state_id' => 'required',
            'status' => 'required|in:1,2,3',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'dist_pdf' => 'nullable|mimes:pdf|max:5120'
        ]);

        $data = new District();
        $data->district_name = $request->district_name;
        $data->district_code = $request->district_code;
        $data->state_id = $request->state_id;
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
		if ($request->hasFile('risk_pdf')) {
            $risk_pdf = $request->file('risk_pdf');
            $pdfName = time() . '_' . $risk_pdf->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/pdf/district');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $risk_pdf->move($destinationPath, $pdfName);

            $data->risk_pdf = $pdfName;
        }

        $data->save();
		
		// Coordinates along with zone

        // $zoneIds = $request->zone_id;
        // $zoneCoordinates = $request->zone_coordinates;
        // $mapShapeIds = $request->mapshapeid;

        // foreach ($zoneIds as $index => $zoneId) {
        //    district_coordinate::create([
        //        'district_id' => $data->id,
        //        'zone_id' => $zoneId,
        //        'zone_coordinates' => $zoneCoordinates[$index] ?? '',
        //        'zonemapshape' => $mapShapeIds[$index] ?? '',
        //    ]);
        // }

        return redirect()->route('admin.manage-district.index')->with('success', 'District added successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = District::where('id', $id)->first();
        // $data = DB::table('districts')
        //         ->select('districts.*','district_coordinates.zone_id','district_coordinates.zone_coordinates','district_coordinates.zonemapshape','district_coordinates.district_id as dist_id')
        //         ->join('district_coordinates','districts.id','district_coordinates.district_id')
        //         ->where('districts.id',$id)
        //         ->get();

        $coords_data = district_coordinate::where('district_id', $id)->get()->keyBy('zone_id');

        $hazard_zone = DB::table('districts_zone')->get();
        $map_shape = DB::table('map_shapes')->get();

        return view('admin.district.edit', compact('data', 'hazard_zone', 'map_shape', 'coords_data'));
    }

    public function update(Request $request, $id)
    {
        $data = District::findOrFail($id);

        $request->validate([
            'district_name' => 'required|string|max:255',
            'status' => 'required|in:1,2,3',
            // 'coordinates' => 'nullable|string|max:255',
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
		 if ($request->hasFile('risk_pdf')) {
            $risk_pdf = $request->file('risk_pdf');
            $pdfName = time() . '_' . $risk_pdf->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/pdf/district');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $risk_pdf->move($destinationPath, $pdfName);

            $data->risk_pdf = $pdfName;
        }


        $data->save();

		// Coordinates along with zone
		
        // district_coordinate::where('district_id', $data->id)->delete();

        //if ($request->has('zone_coordinates')) {
        //    foreach ($request->zone_coordinates as $index => $coord) {
        //        if (!empty($coord)) {
        //            district_coordinate::create([
        //                'district_id' => $data->id,
        //                'zone_id' => $request->zone_id[$index] ?? null,
        //                'zone_coordinates' => $coord,
        //                'zonemapshape' => $request->mapshapeid[$index] ?? null,
        //            ]);
        //        }
        //    }
        //}

        return redirect()->route('admin.manage-district.index')->with('success', 'District updated successfully.');
    }

    public function destroy($id)
    {
        //
    }
}
