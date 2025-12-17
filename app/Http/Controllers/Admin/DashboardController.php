<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuditTrail;

class DashboardController extends Controller
{
    public function index(){
        $data = AuditTrail::latest()->take(5)->get();
        return view('admin.dashboard', compact('data'));
    }
}
