<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'district_name',
        'district_code',
        'image',
        'dist_pdf',
        'image_date',
        'coordinates',
        'state_id',
        'status'
    ];

     public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function hazards()
    {
        return $this->belongsToMany(Hazards::class, 'hazard_districts', 'district_id', 'hazard_id');
    }
}
