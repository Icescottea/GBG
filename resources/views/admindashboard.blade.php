@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Admin Dashboard') }}</h1>

    <!-- Role Assignment Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Assign Role to User</h6>
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

            <form method="POST" action="{{ route('admin.assignRole') }}">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">User Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter user's email" required>
                </div>

                <!-- Role Selection Field -->
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="customer">Customer</option>
                        <option value="outlet_manager">Outlet Manager</option>
                        <option value="head_office_staff">Head Office Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Outlet Selector -->
                <div class="form-group" id="outlet-section" style="display: none;">
                    <label for="outlet_id">Assign Outlet</label>
                    <select id="outlet_id" name="outlet_id" class="form-control">
                        <option value="">-- Select Outlet --</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                            @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Assign Role</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            const outletSection = document.getElementById('outlet-section');
            outletSection.style.display = this.value === 'outlet_manager' ? 'block' : 'none';
        });
    </script>
    

@endsection
