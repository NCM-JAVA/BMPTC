<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class district_coordinate extends Model
{
   protected $fillable = [
        'id',
        'zone_id',
        'zone_coordinates',
        'zonemapshape',
        'district_id'
        
    ];
}
