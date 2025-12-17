<?php

namespace App\Http\Controllers\Api\v1\Location;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getStates(){
        $data = State::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getDistricts($state_id){
        $district = District::where('state_id', $state_id)->get();

        if($district->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'No districts found for this state'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $district
        ], 200);
    }
}
