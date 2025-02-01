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
            <div class="table-responsive"> <!-- Make table scrollable -->
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
                                    @php
                                        $availableStock = $request->type === '5kg' ? $stock['stock_5kg'] : $stock['stock_12kg'];
                                        $pendingStock = $request->type === '5kg' ? $stock['pending_stock_5kg'] : $stock['pending_stock_12kg'];
                                    @endphp

                                    @if (($availableStock + $pendingStock) >= $request->quantity)
                                        <span class="text-success">Ready to Approve</span>
                                    @else
                                        <span class="text-danger">Insufficient Stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if (($availableStock + $pendingStock) >= $request->quantity)
                                        <button class="btn btn-success btn-sm" onclick="approveRequest({{ $request->id }})">Approve</button>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Approve</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Other Sections: Issued Tokens, Stock Levels, Upcoming Deliveries -->
@foreach (['Issued Tokens' => $issuedTokens, 'Stock Levels' => [$stock], 'Upcoming Deliveries' => $upcomingDeliveries] as $title => $data)
    <div class="card mb-4">
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">
            @if (empty($data) || count($data) === 0)
                <p>No data available.</p>
            @else
                <div class="table-responsive"> <!-- Add responsive scrolling -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                @if ($title === 'Issued Tokens')
                                    <th>Token Code</th><th>Customer</th><th>Type</th><th>Quantity</th><th>Pickup End Date</th><th>Action</th>
                                @elseif ($title === 'Stock Levels')
                                    <th>5kg Stock</th><th>5kg Pending Stock</th><th>12kg Stock</th><th>12kg Pending Stock</th>
                                @elseif ($title === 'Upcoming Deliveries')
                                    <th>Scheduled Date</th><th>Incoming Stock (5kg)</th><th>Incoming Stock (12kg)</th><th>Status</th><th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    @if ($title === 'Issued Tokens')
                                        <td>{{ $row->token_code }}</td>
                                        <td>{{ $row->user_name }}</td>
                                        <td>{{ $row->type }}</td>
                                        <td>{{ $row->quantity }}</td>
                                        <td>{{ $row->expires_at }}</td>
                                        <td>
                                            @if ($row->issued_from === 'pending_stock')
                                                <form method="POST" action="{{ route('outletmanager.extendToken', $row->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">Extend</button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>No Extensions</button>
                                            @endif
                                        </td>
                                    @elseif ($title === 'Stock Levels')
                                        <td>{{ $row['stock_5kg'] }} cylinders</td>
                                        <td>{{ $row['pending_stock_5kg'] }} cylinders</td>
                                        <td>{{ $row['stock_12kg'] }} cylinders</td>
                                        <td>{{ $row['pending_stock_12kg'] }} cylinders</td>
                                    @elseif ($title === 'Upcoming Deliveries')
                                        <td>{{ $row->scheduled_date }}</td>
                                        <td>{{ $row->qty_5kg_stock ?? 0 }} cylinders</td>
                                        <td>{{ $row->qty_12kg_stock ?? 0 }} cylinders</td>
                                        <td>{{ ucfirst($row->status) }}</td>
                                        <td>
                                            @if ($row->status === 'pending')
                                                <form method="POST" action="{{ route('outletmanager.receiveDelivery', $row->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Mark as Received</button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>Already Received</button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endforeach

@endsection

<script>
    function approveRequest(id) {
        if (confirm('Are you sure you want to approve this request?')) {
            window.location.href = `/outletmanager/approve/${id}`;
        }
    }
</script>
