<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return response()->json([
            'status' => 'success',
            'message' => greet_users(),
            'data' => 'Data not inserted right now'
        ], 200);
    }
}
