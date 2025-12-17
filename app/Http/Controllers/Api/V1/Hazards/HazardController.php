<?php

namespace App\Http\Controllers\Api\V1\Hazards;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Hazards;

class HazardController extends Controller
{
    public function getHazards(){
        $data = Hazards::where('status', 3)->get()
				->map(function ($item) {
                    $item->hz_image = $item->hz_image 
                        ? asset('public/assets/uploads/img/hazards/' . $item->hz_image)
                        : null;
						
					$item->hz_pdf = $item->hz_pdf 
                        ? asset('public/assets/uploads/pdf/hazards/' . $item->hz_pdf)
                        : null;
						
                    return $item;
                });

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getHazardStates(Request $request){
        
        $hazard_id = $request->hazard_id;

        $hazard_states = DB::table('hazard_states')
                        ->join('states', 'hazard_states.state_id', '=', 'states.id')
                        ->where('hazard_states.hazard_id', $hazard_id)
						->where('states.status', 3)
                        ->select('hazard_states.*', 'states.state_name','states.state_code','states.coordinates as state_coordinates')
						->orderBy('states.state_name', 'ASC')
                        ->get()
						->map(function ($item) {
							$item->image_url = $item->attachment 
								? asset('public/assets/uploads/img/hazards/state_img/' . $item->attachment)
								: null;
							return $item;
						});

        return response()->json([
            'status' => true,
            'data' => $hazard_states ?? 'No data found'
        ], 200);
    }

    public function getHazardDistrict(Request $request){

        $hazard_id = $request->hazard_id;
        $state_id = $request->state_id;
		
		$hazard_states = DB::table('hazard_states')
            ->join('states', 'hazard_states.state_id', '=', 'states.id')
            ->where('hazard_states.hazard_id', $hazard_id)
            ->where('hazard_states.state_id', $state_id)
            ->select('hazard_states.*', 'states.state_name', 'states.state_code', 'states.St_pdf','states.coordinates as state_coordinates')
            ->first();
           
        //$hazard_states->St_pdf = $hazard_states->St_pdf 
        //        ? asset('public/assets/uploads/pdf/state/' . $hazard_states->St_pdf)
        //        : null;
				
		if ($hazard_states && !empty($hazard_states->St_pdf)) {
			$hazard_states->St_pdf = filter_var($hazard_states->St_pdf, FILTER_VALIDATE_URL)
				? $hazard_states->St_pdf
				: asset('public/assets/uploads/pdf/state/' . $hazard_states->St_pdf);
		} else {
			$hazard_states = (object) ['St_pdf' => null];
		}


        $hazard_states->attachment = !empty($hazard_states->attachment) 
                ? asset('public/assets/uploads/img/hazards/state_img/' . $hazard_states->attachment)
                : null;

        $hazard_districts = DB::table('hazard_districts')
            ->join('districts', 'hazard_districts.district_id', '=', 'districts.id')
            ->where('hazard_districts.hazard_id', $hazard_id)
            ->where('hazard_districts.state_id', $state_id)
            ->select('hazard_districts.*', 'districts.district_name', 'districts.coordinates as district_coordinates')
            ->get();	

        return response()->json([
            'status' => true,
			'state_data' => $hazard_states,	
            'data' => $hazard_districts
        ], 200);
    }

    public function district_pdf(Request $request){
		$hazard_id = $request->hazard_id;
		$state_id = $request->state_id;
		$district_id = $request->district_id;

		$hazard_district_pdf = DB::table('hazard_districts')
			->join('districts', 'hazard_districts.district_id', '=', 'districts.id')
			->where('hazard_districts.hazard_id', $hazard_id)
			->where('hazard_districts.state_id', $state_id)
			->where('hazard_districts.district_id', $district_id)
			->select('districts.id','districts.state_id','districts.district_name','districts.dist_pdf')
			->first();								

		if ($hazard_district_pdf) {
			$pdfUrl = $hazard_district_pdf->dist_pdf ? asset('public/assets/uploads/pdf/district/' . $hazard_district_pdf->dist_pdf) : null;
            return response()->json([
                'id' => $hazard_district_pdf->id,
                'state_id' => $hazard_district_pdf->state_id,
                'district_name' => $hazard_district_pdf->district_name,
                'pdf_url' => $pdfUrl,
            ]);
		} else {			
			return response()->json(['message' => 'No data found'], 404);
		}

    }
}
