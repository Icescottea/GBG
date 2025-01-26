@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Outlet Manager Dashboard') }}</h1>

    <!-- Gas Requests Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Incoming Gas Requests</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Customer Name</th>
                        <th>Quantity</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data -->
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>2</td>
                        <td>5kg</td>
                        <td>Pending</td>
                        <td>
                            <button class="btn btn-success btn-sm approve-btn">Approve</button>
                            <button class="btn btn-danger btn-sm reject-btn">Reject</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>1</td>
                        <td>12kg</td>
                        <td>Pending</td>
                        <td>
                            <button class="btn btn-success btn-sm approve-btn">Approve</button>
                            <button class="btn btn-danger btn-sm reject-btn">Reject</button>
                        </td>
                    </tr>
                    <!-- Dynamic rows can be added here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stock Levels Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock Levels</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- 5kg Stock -->
                <div class="col-md-6">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            5kg Cylinders
                            <div class="text-white-50 small">Available: 50</div>
                        </div>
                    </div>
                </div>
                <!-- 12kg Stock -->
                <div class="col-md-6">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            12kg Cylinders
                            <div class="text-white-50 small">Available: 30</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Approve/Reject Actions -->
    <script>
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', () => {
                alert('Request Approved!');
            });
        });

        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', () => {
                alert('Request Rejected!');
            });
        });
    </script>
@endsection
