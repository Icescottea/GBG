@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Outlet Manager Dashboard</h1>

<!-- Pending Requests -->
<div class="card mb-4">
    <div class="card-header">Pending Requests</div>
    <div class="card-body">
        @if ($gasRequests->isEmpty())
            <p>No pending requests available.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gasRequests as $request)
                        <tr>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->type }}</td>
                            <td>{{ $request->quantity }}</td>
                            <td>
                                @if (($request->type === '5kg' && $stock['stock_5kg'] >= $request->quantity) || 
                                     ($request->type === '12kg' && $stock['stock_12kg'] >= $request->quantity))
                                    <span class="text-success">Ready to Approve</span>
                                @else
                                    <span class="text-danger">Insufficient Stock</span>
                                @endif
                            </td>
                            <td>
                                @if (($request->type === '5kg' && $stock['stock_5kg'] >= $request->quantity) || 
                                     ($request->type === '12kg' && $stock['stock_12kg'] >= $request->quantity))
                                    <button class="btn btn-success btn-sm" onclick="approveRequest({{ $request->id }})">Approve</button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Approve</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- Stock Levels -->
<div class="card mb-4">
    <div class="card-header">Stock Levels</div>
    <div class="card-body">
        <p><strong>5kg:</strong> {{ $stock['stock_5kg'] }} cylinders</p>
        <p><strong>12kg:</strong> {{ $stock['stock_12kg'] }} cylinders</p>
    </div>
</div>

<!-- Upcoming Deliveries -->
<div class="card mb-4">
    <div class="card-header">Upcoming Deliveries</div>
    <div class="card-body">
        @if ($upcomingDeliveries->isEmpty())
            <p>No upcoming deliveries scheduled.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Scheduled Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($upcomingDeliveries as $delivery)
                        <tr>
                            <td>{{ $delivery->scheduled_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

<script>
    function approveRequest(id) {
        if (confirm('Are you sure you want to approve this request?')) {
            window.location.href = `/outletmanager/approve/${id}`;
        }
    }
</script>
