@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Outlet Manager Dashboard</h1>

<!-- Pending Requests -->
<div class="card mb-4">
    <div class="card-header">Pending Requests</div>
    <div class="card-body">
        @forelse ($gasRequests as $request)
            <div class="border p-3 mb-3">
                <p><strong>Customer:</strong> {{ $request->user->name }}</p>
                <p><strong>Type:</strong> {{ $request->type }}</p>
                <p><strong>Quantity:</strong> {{ $request->quantity }}</p>
                <button class="btn btn-success btn-sm" onclick="approveRequest({{ $request->id }})">Approve</button>
                <button class="btn btn-danger btn-sm" onclick="denyRequest({{ $request->id }})">Deny</button>
            </div>
        @empty
            <p>No pending requests.</p>
        @endforelse
    </div>
</div>

<!-- Stock Levels -->
<div class="card mb-4">
    <div class="card-header">Stock Levels</div>
    <div class="card-body">
        <p><strong>5kg:</strong> {{ $stock->stock_5kg ?? 0 }} cylinders</p>
        <p><strong>12kg:</strong> {{ $stock->stock_12kg ?? 0 }} cylinders</p>
    </div>
</div>

<!-- Upcoming Deliveries -->
<div class="card mb-4">
    <div class="card-header">Upcoming Deliveries</div>
    <div class="card-body">
        @forelse ($upcomingDeliveries as $delivery)
            <div class="mb-2">
                <p><strong>Date:</strong> {{ $delivery->scheduled_date }}</p>
                <p><strong>Status:</strong> {{ ucfirst($delivery->status) }}</p>
            </div>
        @empty
            <p>No upcoming deliveries.</p>
        @endforelse
    </div>
</div>
@endsection

<script>
    function approveRequest(id) {
        if (confirm('Are you sure you want to approve this request?')) {
            window.location.href = `/outletmanager/approve/${id}`;
        }
    }

    function denyRequest(id) {
        if (confirm('Are you sure you want to deny this request?')) {
            window.location.href = `/outletmanager/deny/${id}`;
        }
    }
</script>
