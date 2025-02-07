@extends('layouts.admin')

@section('main-content')

    <style>
        .card {
            border-radius: 10px; /* Rounded corners */
            padding: 10px;
            background: #ffffff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Softer shadows */
        }

        .card-title {
            font-weight: bold;
            color: #333;
        }

        .display-4 {
            font-weight: 700;
            color: #2c3e50; /* Darker text for contrast */
        }

        .row {
            margin-top: 20px;
            gap: 15px; /* Ensure even spacing */
        }
    </style>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 d-flex justify-content-between align-items-center">
        {{ __('Head Office') }}
        <button id="toggleDispatch" class="btn btn-primary">Dispatch Office</button>
    </h1>

    <form method="GET" action="{{ route('headoffice') }}">
        <label for="outlet_id">Select Outlet:</label>
        <select name="outlet_id" id="outlet_id" class="form-control" onchange="this.form.submit()">
            @foreach($outlets as $outlet)
                <option value="{{ $outlet->id }}" {{ $selectedOutletId == $outlet->id ? 'selected' : '' }}>
                    {{ $outlet->name ?? 'Unknown Outlet' }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Dashboard Stats Row -->
    <div class="row justify-content-center">
        <!-- Monthly Requests Chart -->
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Monthly Requests</h5>
                    <canvas id="monthlyRequestsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Completed Tokens (Centered) -->
        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <div class="card shadow text-center w-100">
                <div class="card-body">
                    <h5 class="card-title">Completed Tokens</h5>
                    <h2 class="display-4">{{ $completedTokens }}</h2>
                </div>
            </div>
        </div>

        <!-- Sold Cylinders Chart -->
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Sold Cylinders</h5>
                    <canvas id="soldCylindersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Head Office Section -->
    <div id="headOfficeSection">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Outlet Information</h6>
            </div>
            <div class="card-body">
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
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
        </div>
    </div>

    <!-- Dispatch Office Section -->
    <div id="dispatchOfficeSection" style="display: none;">
        <h4 class="mt-4">Dispatch Office</h4>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Delivery</h6>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-left-danger" role="alert">
                        <ul class="pl-4 my-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('dispatch.addDelivery') }}">
                    @csrf

                    <!-- Outlet Selector -->
                    <div class="form-group">
                        <label for="outlet_id">Select Outlet</label>
                        <select id="outlet_id" name="outlet_id" class="form-control" required>
                            <option value="">-- Select Outlet --</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Scheduled Date -->
                    <div class="form-group">
                        <label for="scheduled_date">Scheduled Date</label>
                        <input type="date" id="scheduled_date" name="scheduled_date" class="form-control" required>
                    </div>

                    <!-- Quantity of 5kg Stock -->
                    <div class="form-group">
                        <label for="qty_5kg_stock">Quantity of 5kg Stock</label>
                        <input type="number" id="qty_5kg_stock" name="qty_5kg_stock" class="form-control" min="0" required>
                    </div>
                
                    <!-- Quantity of 12kg Stock -->
                    <div class="form-group">
                        <label for="qty_12kg_stock">Quantity of 12kg Stock</label>
                        <input type="number" id="qty_12kg_stock" name="qty_12kg_stock" class="form-control" min="0" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Add Delivery</button>
                </form>
            </div>
        </div>

        <!-- Deliveries List -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Deliveries</h6>
            </div>
            <div class="card-body">
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Outlet</th>
                                <th>Scheduled Date</th>
                                <th>Delivered Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliveries as $delivery)
                                <tr>
                                    <td>{{ $delivery->outlet->name }}</td>
                                    <td>{{ $delivery->scheduled_date }}</td>
                                    <td>{{ $delivery->delivered_date ?? 'Not Delivered' }}</td>
                                    <td>{{ ucfirst($delivery->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('toggleDispatch').addEventListener('click', function () {
            const headOfficeSection = document.getElementById('headOfficeSection');
            const dispatchOfficeSection = document.getElementById('dispatchOfficeSection');

            if (dispatchOfficeSection.style.display === 'none') {
                headOfficeSection.style.display = 'none';
                dispatchOfficeSection.style.display = 'block';
            } else {
                headOfficeSection.style.display = 'block';
                dispatchOfficeSection.style.display = 'none';
            }
        });
        
        const ctx = document.getElementById('monthlyRequestsChart').getContext('2d');
        const monthlyData = @json($monthlyRequests);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(data => data.month), // Use month names
                datasets: [{
                    label: 'Gas Requests',
                    data: monthlyData.map(data => data.count),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

        const soldCtx = document.getElementById('soldCylindersChart').getContext('2d');
        const soldData = {
            labels: ['5kg Cylinders', '12kg Cylinders'],
            datasets: [{
                label: 'Sold Cylinders',
                data: [{{ $soldCylinders->total_5kg ?? 0 }}, {{ $soldCylinders->total_12kg ?? 0 }}],
                backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        
        new Chart(soldCtx, {
            type: 'bar',
            data: soldData,
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

    
        // Update Completed Tokens Count
        document.getElementById('completedTokens').innerText = "{{ $completedTokens }}";
    
    </script>
@endsection
