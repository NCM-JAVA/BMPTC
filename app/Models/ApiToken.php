<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    use HasFactory;
    protected $fillable = ['token', 'expires_at'];
    protected $casts = ['expires_at' => 'datetime'];

    public static function getActiveToken()
    {
        $token = self::latest()->first();

        if (!$token || $token->expires_at->isPast()) {
            $token = self::create([
                'token' => bin2hex(random_bytes(30)), 
                'expires_at' => now()->addDays(7),
            ]);
        }

        return $token;
    }
}
