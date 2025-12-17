<?php

use App\Models\AuditTrail;
use Illuminate\Support\Facades\File;

if (!function_exists('greet_users')) {
    function greet_users()
    {
        return "Welcome to BMTPC";
    }
}

if (!function_exists('get_status')) {
    function get_status()
    {
        $status = [
            '1' => "Draft",
            '2' => "Aproval",
            '3' => "Publish"
        ];
        return $status;
    }
}

function status($val){
    if($val == 1){
        echo 'Draft';
    }else if($val == 2){
        echo 'Approval';
    }else if($val == 3){
        echo 'Publish';
    }else{
        echo 'Review';
    }
}

// User Role
if (!function_exists('get_role')) {
    function get_role()
    {
        $role = [
            '1' => "Admin",
            '2' => "Sub-Admin"
        ];
        return $role;
    }
}

if (!function_exists('user_role')) {
    function user_role($val)
    {
        if($val == 1){
            echo 'Admin';
        }else if($val == 2){
            echo 'Sub-Admin';
        }
    }
}


//Audit Trails
if (!function_exists('createAuditTrail')) {
    function createAuditTrail($event, $module, $oldValues = null, $newValues = null, $approveStatus = 0)
    {
        $user = Auth::user();

        AuditTrail::create([
            'user_id' => $user?->id,
            'usertype' => $user?->role == 1 ? 'Admin' : 'User',
            'event' => $event,
            'event_date' => now(),
            'approve_status' => $approveStatus,
            'module' => $module,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip()
        ]);
    }
}

//Remove files from DB and Storage
if (!function_exists('removeFileAndUpdateDB')) {
    function removeFileAndUpdateDB($model, $column, $path)
    {
        if (!$model || !$model->$column) {
            return false;
        }

        $filePath = public_path($path . $model->$column);

        if (File::exists($filePath)) {
            
            File::delete($filePath);
        }

        $model->$column = null;
        $model->save();

        return true;
    }
}