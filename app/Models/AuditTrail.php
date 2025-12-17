<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $fillable = [
        'user_id', 
        'usertype', 
        'event', 
        'event_date', 
        'approve_status', 
        'module',
        'old_values', 
        'new_values',
        'ip_address'
    ];

}
