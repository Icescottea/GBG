<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasRequest extends Model
{
    use HasFactory;

    protected $table = 'gas_requests';

    protected $fillable = [
        'user_id',
        'outlet_id',
        'type',
        'quantity',
        'token_id',
        'issued_from'.
        'status',
        'requested_date',
        'scheduled_date',
    ];

    // Relationships
    public function user()
    {        return $this->belongsTo(User::class, 'user_id');     }

    public function outlet()
    {        return $this->belongsTo(Outlet::class, 'outlet_id');    }

    public function token()
    {        return $this->belongsTo(Token::class, 'token_id');    }
}
