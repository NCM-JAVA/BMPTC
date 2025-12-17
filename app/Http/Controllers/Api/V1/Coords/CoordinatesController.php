<?php

namespace App\Http\Controllers\Api\V1\Coords;

use App\Http\Controllers\Controller;
use App\Models\State;
use DB;
use Illuminate\Http\Request;

class CoordinatesController extends Controller
{
    public function getHazardStateCoordinates(Request $request)
    {
        $hazard_id = $request->hazard_id;

        // $state_coords = State::where('status', 3)
        //     ->select('id as state_id', 'state_name', 'coordinates')
        $state_coords = DB::table('hazard_states')
            ->join('states', 'hazard_states.state_id', '=', 'states.id')
            ->where('hazard_states.hazard_id', $hazard_id)
            ->whereNotNull('states.coordinates')
            ->select(
                'states.id as state_id',
                'states.state_name',
                'states.coordinates'
            )
            ->get()
            ->map(function ($state) {
                $coordsArray = array_map('floatval', array_map('trim', explode(',', $state->coordinates)));
                $formatted = [];

                for ($i = 0; $i < count($coordsArray); $i += 2) {
                    if (isset($coordsArray[$i + 1])) {
                        $formatted[] = [
                            'lat' => $coordsArray[$i],
                            'lng' => $coordsArray[$i + 1],
                        ];
                    }
                }

                $state->coordinates = $formatted;
                return $state;
            });

        return response()->json([
            'status' => $state_coords->isNotEmpty(),
            'data' => $state_coords->isNotEmpty() ? $state_coords : 'No data found',
        ], 200);

    }

    public function getHazardDistrictCoordinates(Request $request)
    {
        $hazard_id = $request->hazard_id;
        $state_id = $request->state_id;

        $district_coords = DB::table('hazard_districts')
            ->join('districts', 'hazard_districts.district_id', '=', 'districts.id')
            ->where('hazard_districts.hazard_id', $hazard_id)
            ->where('hazard_districts.state_id', $state_id)
            ->whereNotNull('districts.coordinates')
            ->select(
                'districts.id as district_id',
                'districts.state_id',
                'districts.district_name',
                'districts.coordinates'
            )
            ->get()
            ->map(function ($district) {
                $coordsArray = array_map('floatval', array_map('trim', explode(',', $district->coordinates)));
                $formatted = [];

                for ($i = 0; $i < count($coordsArray); $i += 2) {
                    if (isset($coordsArray[$i + 1])) {
                        $formatted[] = [
                            'lat' => $coordsArray[$i],
                            'lng' => $coordsArray[$i + 1],
                        ];
                    }
                }

                $district->coordinates = $formatted;
                return $district;
            });

        return response()->json([
            'status' => $district_coords->isNotEmpty(),
            'data' => $district_coords->isNotEmpty() ? $district_coords : 'No data found',
        ], 200);
    }
}
