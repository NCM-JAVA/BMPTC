<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\hazard_district;
use App\Models\hazard_state;
use App\Models\Hazards;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HazardController extends Controller
{
    public function index(){
        $data = Hazards::with(['states','districts'])->paginate(10);
        return view('admin.hazard.index',compact('data'));
    }

     public function create()
    {
        $states = State::orderBy('state_name','ASC')->get();
        return view('admin.hazard.add', compact('states'));
    }

    public function getDistricts(Request $request)
    {
        $state_id = $request->state_id;
        $hazard_id = $request->hazard_id;
        
        $hazard_districts = hazard_district::where('state_id', $state_id)
        ->where('hazard_id', $hazard_id)
        ->pluck('district_id')
        ->toArray();

        $districts = District::where('state_id', $state_id)
            ->orderBy('district_name', 'ASC')
            ->get();

        $html = '';
        foreach ($districts as $district) {
            $checked = in_array($district->id, $hazard_districts) ? 'checked' : '';

            $html .= '
                <div class="col-md-4">
                    <div class="form-check"> 
                        <input class="form-check-input district-checkbox" type="checkbox" 
                            name="districts[]" value="'.$district->id.'" 
                            id="district_'.$district->id.'" '.$checked.'>
                        <label class="form-check-label" for="district_'.$district->id.'">
                            '.$district->district_name.'
                        </label>
                    </div>
                </div>
            ';
        }

        return $html ?: '<p class="text-muted">No districts found</p>';

        // return response()->json($districts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:hazards,name|max:255',
            'hz_code' => 'required|string|unique:hazards,hz_code|max:255',
            'hz_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'hz_pdf' => 'nullable|mimes:pdf|max:5120',
            'state' => 'required|exists:states,id',
            'districts' => 'required|array|min:1',
            'districts.*' => 'exists:districts,id',
            'status' => 'required|in:1,2,3'
        ], [
            'name.unique' => 'Hazard name must be unique.'
        ]);

        $data = new Hazards();
        $data->name = $request->name;
        $data->hz_code = $request->hz_code;
        $data->status = $request->status;

        if ($request->hasFile('hz_image')) {
            $image = $request->file('hz_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/img/hazards');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);

            $data->hz_image = $imageName;
        }

        if ($request->hasFile('hz_pdf')) {
            $hz_pdf = $request->file('hz_pdf');
            $pdfName = time() . '_' . $hz_pdf->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/pdf/hazards');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $hz_pdf->move($destinationPath, $pdfName);

            $data->hz_pdf = $pdfName;
        }

        $data->save();

       $existingStates = DB::table('hazard_states')
            ->where('hazard_id', $data->id)
            ->pluck('state_id')
            ->toArray();

        $existingDistricts = DB::table('hazard_districts')
            ->where('hazard_id', $data->id)
            ->pluck('district_id')
            ->toArray();

        $stateId = $request->state; 
        $duplicateStates = $data->states()->where('state_id', $stateId)->exists();
        $duplicateDistricts = array_intersect($existingDistricts, $validated['districts']);

        if (!empty($duplicateStates) || !empty($duplicateDistricts)) {
            $duplicateStateNames = State::whereIn('id', $duplicateStates)->pluck('name')->implode(', ');
            $duplicateDistrictNames = District::whereIn('id', $duplicateDistricts)->pluck('name')->implode(', ');

            DB::rollBack();

            $errorMessage = '';
            if (!empty($duplicateStateNames)) {
                $errorMessage .= "State(s) '{$duplicateStateNames}' already linked with this hazard. ";
            }
            if (!empty($duplicateDistrictNames)) {
                $errorMessage .= "District(s) '{$duplicateDistrictNames}' already linked with this hazard.";
            }

            return back()->with('error', trim($errorMessage))->withInput();
        }

        $data->states()->syncWithoutDetaching($validated['state']);
        $data->districts()->syncWithoutDetaching($validated['districts']);

        return redirect()->route('admin.manage-hazard.index')->with('success', 'Hazards added successfully.');
    }

     public function show($id)
    {
        $hazard = Hazards::where('id', $id)->first();
        $hazard_states = DB::table('hazard_states')
                        ->join('states', 'hazard_states.state_id', '=', 'states.id')
                        ->where('hazard_states.hazard_id', $id)
                        ->select('hazard_states.*', 'states.state_name')
                        ->get();

        $hazard_districts = [];
        foreach ($hazard_states as $state) {
            $districts = DB::table('hazard_districts')
                ->join('districts', 'hazard_districts.district_id', '=', 'districts.id')
                ->where('hazard_districts.hazard_id', $id)
                ->where('hazard_districts.state_id', $state->state_id)
                ->select('hazard_districts.*', 'districts.district_name')
                ->get();
            $hazard_districts[$state->state_id] = $districts;
        }

        return view('admin.hazard.view', compact('hazard','hazard_states','hazard_districts'));
    }

    public function edit($id)
    {
        $states = State::orderBy('state_name','ASC')->get();
        $data = Hazards::where('id', $id)->first();
        $hazard_states = hazard_state::where('hazard_id',$id)->first();
        if ($hazard_states) {
            $hazard_districts = hazard_district::where('hazard_id',$id)
                                ->where('state_id', $hazard_states->state_id)
                                ->get();
        } else {
            $hazard_districts = collect();
        }

        return view('admin.hazard.edit', compact('data','states','hazard_states','hazard_districts'));
    }

    public function update(Request $request, $id)
    {
        $data = Hazards::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:1,2,3',
            'hz_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'hz_pdf' => 'nullable|mimes:pdf|max:5120',
            'state' => 'required|exists:states,id',
            'districts' => 'required|array|min:1',
            'districts.*' => 'exists:districts,id',
        ]);

        $data->name = $request->name;
        $data->status = $request->status;
 
        if ($request->hasFile('hz_image')) {
            $image = $request->file('hz_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/img/hazards');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);

            $data->hz_image = $imageName;
        }

        if ($request->hasFile('hz_pdf')) {
            $hz_pdf = $request->file('hz_pdf');
            $pdfName = time() . '_' . $hz_pdf->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/pdf/hazards');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $hz_pdf->move($destinationPath, $pdfName);

            $data->hz_pdf = $pdfName;
        }

        $data->save();

        $existingStates = DB::table('hazard_states')
            ->where('hazard_id', $data->id)
            ->pluck('state_id')
            ->toArray();

        $existingDistricts = DB::table('hazard_districts')
            ->where('hazard_id', $data->id)
            ->pluck('district_id')
            ->toArray();

        $stateId = $request->state; 
        $duplicateStates = $data->states()->where('state_id', $stateId)->exists();
        $duplicateDistricts = array_intersect($existingDistricts, $validated['districts']);

        // if (!empty($duplicateStates) || !empty($duplicateDistricts)) {
        //     $duplicateStateNames = State::where('id', $duplicateStates)->pluck('state_name')->first();
        //     $duplicateDistrictNames = District::whereIn('id', $duplicateDistricts)->pluck('district_name')->implode(', ');

        //     DB::rollBack();

        //     $errorMessage = '';
        //     if (!empty($duplicateStateNames)) {
        //         $errorMessage .= "State(s) '{$duplicateStateNames}' already linked with this hazard. ";
        //     }
        //     if (!empty($duplicateDistrictNames)) {
        //         $errorMessage .= "District(s) '{$duplicateDistrictNames}' already linked with this hazard.";
        //     }

        //     return back()->with('error', trim($errorMessage))->withInput();
        // }

        $data->states()->syncWithoutDetaching($validated['state']);

         DB::table('hazard_districts')
                ->where('hazard_id', $data->id)
                ->where('state_id', $stateId)
                ->delete();
        
        $attach = [];
        foreach ($validated['districts'] as $districtId) {
            $attach[$districtId] = ['state_id' => $stateId];
        }

        $data->districts()->attach($attach);
        // $data->districts()->syncWithoutDetaching($attach);
        // $data->districts()->syncWithoutDetaching($validated['districts']);

        return redirect()->route('admin.manage-hazard.index')->with('success', 'Hazard updated successfully.');
    }

    public function destroy($id)
    {
        //
    }
}
