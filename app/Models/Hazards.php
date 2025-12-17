<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hazards extends Model
{
    protected $fillable = [
        'name',
        'hz_code',
        'hz_pdf',
        'hz_image',
        'status'
    ];

    public function states()
    {
        return $this->belongsToMany(State::class, 'hazard_states', 'hazard_id', 'state_id')->withTimestamps();;
    }

    public function districts()
    {
        // return $this->belongsToMany(District::class, 'hazard_districts', 'hazard_id', 'district_id');
        return $this->belongsToMany(District::class, 'hazard_districts', 'hazard_id', 'district_id')
                ->withPivot('state_id')
                ->withTimestamps();
    }

    
}
