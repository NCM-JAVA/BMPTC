<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MobileAppContent extends Model
{

    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'page_name',
        'title',
        'content',
        'attachment',
        'status'
    ];
}
