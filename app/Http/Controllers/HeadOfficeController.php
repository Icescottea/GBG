<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\Delivery;

class HeadOfficeController extends Controller
{
    public function index()
    {
        // Retrieve outlet statuses and map 0/1 to 'Active'/'Inactive'
        $outletStatuses = Outlet::select('id', 'name', 'status', 'stock_5kg', 'stock_12kg')
            ->get()
            ->map(function ($outlet) {
                $outlet->status = $outlet->status == 0 ? 'Active' : 'Inactive';
                return $outlet;
            });

        // Retrieve count of pending deliveries
        $pendingDeliveries = Delivery::where('status', 'pending')->count();

        return view('headoffice', compact('outletStatuses', 'pendingDeliveries'));
    }
}
