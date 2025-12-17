<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(){
        $audit_trails = AuditTrail::latest()->paginate(10);
        return view('admin.audittrail.index', compact('audit_trails'));
    }
}
