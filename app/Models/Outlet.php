<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'outlet';

    // Fillable attributes for mass assignment
    protected $fillable = ['name', 'location', 'phone', 'status', 'manager_email', 'stock_5kg', 'stock_12kg', 'pending_stock_5kg', 'pending_stock_12kg'];

    /**
     * Define relationship with deliveries.
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'outlet_id', 'id');
    }

    // Function to check stock levels and update status
    public function updateStatus()
    {
        if ($this->stock_5kg == 0 && $this->stock_12kg == 0 &&
            $this->pending_stock_5kg == 0 && $this->pending_stock_12kg == 0) {
            $this->status = 1; // Set as inactive
        } else {
            $this->status = 0; // Set as active
        }
        $this->save();
    }

    /**
     * Define relationship with gas requests.
     */
    public function gasRequests()
    {
        return $this->hasMany(GasRequest::class, 'outlet_id', 'id');
    }

    /**
     * Define relationship with manager (User model).
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_email', 'email');
    }
}
