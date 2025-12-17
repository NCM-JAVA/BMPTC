<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hazard_state extends Model
{
    use HasFactory;

    // protected $table = 'hazard_state';
    
    protected $fillable = [
        'hazard_id',
        'state_id',
        'severity',
        'description',
        'attachment',
        'coordinates',
        'source',
        'status'
    ];
}
