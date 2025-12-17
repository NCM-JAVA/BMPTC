<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_name',
        'state_code',
        'image',
        'image_date',
        'coordinates',
        'status'
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function hazards()
    {
        return $this->belongsToMany(Hazards::class, 'hazard_states', 'state_id', 'hazard_id');
    }
}
