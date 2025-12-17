<?php

namespace App\Http\Controllers\Api\V1\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function feedbackForm(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|max:10',
            'email' => 'required|email|max:255',
            'comments' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $feedback = Feedback::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'comments'   => $request->comments
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thank you! Your feedback has been submitted successfully.',
            'data'   => $request->all()
        ], 200);
    }
}
