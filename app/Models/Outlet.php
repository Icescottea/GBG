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
    protected $fillable = ['name', 'location', 'phone', 'status', 'manager_email'];

}
