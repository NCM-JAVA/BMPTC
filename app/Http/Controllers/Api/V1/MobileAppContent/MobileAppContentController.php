<?php

namespace App\Http\Controllers\Api\V1\MobileAppContent;

use App\Http\Controllers\Controller;
use App\Models\MobileAppContent;

class MobileAppContentController extends Controller
{
    public function getMobileContent(){
        $data = MobileAppContent::select('id','page_name','title','content','attachment','created_at')
                ->where('status', 3)->orderBy('id', 'ASC')->get();

        foreach($data as $val){
			if($val->attachment){																				
				$val->attachment = env('APP_URL').'/public/assets/uploads/img/mobileAppContent/'.$val->attachment;
			}
        }
        
        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
