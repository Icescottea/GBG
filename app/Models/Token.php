<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['token_code','user_id','status','expires_at',];

    protected $casts = [
        'expires_at' => 'datetime', // Ensure expires_at is treated as a Carbon instance
    ];

    //Define the relationship to the GasRequest model. A token belongs to a single gas request.
    public function gasRequest()
    {      return $this->hasOne(GasRequest::class, 'token_id', 'id');    }

    //Define the relationship to the Outlet model through GasRequest. A token is associated with an outlet through its gas request.
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

    // Define the relationship to the User model. A token is issued to a single user.
    public function user()
    {      return $this->belongsTo(User::class, 'user_id', 'id');    }
}
