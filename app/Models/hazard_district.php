<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hazard_district extends Model
{
    use HasFactory;

    // protected $table = 'hazard_district';
    

    protected $fillable = [
        'hazard_id',
        'state_id',
        'district_id',
        'severity',
        'description',
        'attachment',
        'coordinates',
        'source',
        'status'
    ];
}
