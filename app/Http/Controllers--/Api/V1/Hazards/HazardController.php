<?php

namespace App\Http\Controllers\Api\V1\Hazards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hazards;

class HazardController extends Controller
{
    public function getHazards(){
        $data = Hazards::where('status', 3)->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
