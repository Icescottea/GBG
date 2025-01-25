@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Head Office Dashboard') }}</h1>

    <!-- Outlet Statuses -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Outlet Information</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Outlet Name</th>
                        <th>Status</th>
                        <th>5kg Stock Level</th>
                        <th>12kg Stock Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outletStatuses as $outlet)
                        <tr>
                            <td>{{ $outlet->name }}</td>
                            <td>{{ $outlet->status }}</td>
                            <td>{{ $outlet->stock_5kg }}</td>
                            <td>{{ $outlet->stock_12kg }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pending Deliveries -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pending Deliveries</h6>
        </div>
        <div class="card-body">
            <p>There are {{ $pendingDeliveries }} pending deliveries.</p>
        </div>
    </div>
@endsection
