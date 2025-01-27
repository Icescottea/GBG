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

        // Retrieve all deliveries for the dispatch office view
        $deliveries = Delivery::with('outlet:id,name')->orderBy('scheduled_date', 'asc')->get();

        // Retrieve outlets for the dropdown in the delivery form
        $outlets = Outlet::select('id', 'name')->get();

        return view('headoffice', compact('outletStatuses', 'pendingDeliveries', 'deliveries', 'outlets'));
    }

    public function storeDelivery(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlet,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'qty_5kg_stock' => 'required|integer|min:0',
            'qty_12kg_stock' => 'required|integer|min:0',
        ]);
    
        Delivery::create([
            'outlet_id' => $request->outlet_id,
            'scheduled_date' => $request->scheduled_date,
            'qty_5kg_stock' => $request->qty_5kg_stock,
            'qty_12kg_stock' => $request->qty_12kg_stock,
            'status' => 'pending',
        ]);
    
        return redirect()->route('headoffice')->with('success', 'Delivery scheduled successfully!');
    }

}
