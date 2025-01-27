<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'token_code',
        'user_id',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime', // Ensure expires_at is treated as a Carbon instance
    ];

    public function gasRequest()
    {
        return $this->belongsTo(GasRequest::class, 'id', 'token_id');
    }

    public function outlet()
    {
        return $this->hasOneThrough(
            Outlet::class,
            GasRequest::class,
            'token_id',   // Foreign key on GasRequest table
            'id',         // Foreign key on Outlet table
            'id',         // Local key on Tokens table
            'outlet_id'   // Local key on GasRequest table
        );
    }
}
