@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 d-flex justify-content-between align-items-center">
        {{ __('Head Office') }}
        <button id="toggleDispatch" class="btn btn-primary">Dispatch Office</button>
    </h1>

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
    </script>
@endsection
