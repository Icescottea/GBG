@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Head Office Dashboard') }}</h1>

    <!-- Outlet Statuses -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Outlet Statuses</h6>
        </div>
        <div class="card-body">
            <ul>
                @foreach ($outletStatuses as $outlet)
                    <li>
                        <strong>{{ $outlet->name }}</strong>: {{ $outlet->status }}
                    </li>
                @endforeach
            </ul>
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
