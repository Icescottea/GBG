<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deliveries'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'outlet_id',
        'scheduled_date',
        'delivered_date',
        'status',
        'qty_5kg_stock',
        'qty_12kg_stock',
    ];

    /**
     * Relationship: A delivery belongs to an outlet.
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }
}
