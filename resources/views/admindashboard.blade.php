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

            <!-- Email Input -->
            <form method="GET" action="{{ route('admindashboard') }}">
                <div class="form-group">
                    <label for="email">User Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter user's email" value="{{ request('email') }}" required>
                    <button type="submit" class="btn btn-primary mt-2">Search User</button>
                </div>
            </form>

            <!-- Assign Role -->
            @if ($selectedUser)
                <form method="POST" action="{{ route('admin.assignRole') }}">
                    @csrf

                    <!-- Role Selection -->
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="customer" {{ $selectedUser->role == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="outlet_manager" {{ $selectedUser->role == 'outlet_manager' ? 'selected' : '' }}>Outlet Manager</option>
                            <option value="head_office_staff" {{ $selectedUser->role == 'head_office_staff' ? 'selected' : '' }}>Head Office Staff</option>
                            <option value="admin" {{ $selectedUser->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="business" {{ $selectedUser->role == 'business' ? 'selected' : '' }}>Business</option>
                        </select>
                    </div>

                    <!-- Certificate Display (For Business Users) -->
                    <div id="business-verification" style="{{ $selectedUser->role == 'business' ? 'display: block' : 'display: none' }}">
                        <div class="form-group">
                            <label for="certificate">Uploaded Certificate</label>
                            <br>
                            @if($selectedUser->certificate_path)
                            <a href="{{ asset('storage/' . $selectedUser->certificate_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $selectedUser->certificate_path) }}" alt="Certificate" width="300">
                            </a>                            
                            @else
                                <p>No certificate uploaded.</p>
                            @endif
                        </div>

                        <!-- Business Verification Checkbox -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="business_verified" id="business_verified" value="1" 
                                       {{ isset($selectedUser) && $selectedUser->is_verified ? 'checked' : '' }}>
                                Approve Business Registration
                            </label>
                        </div>
                    </div>

                    <!-- Outlet Selector -->
                    <div class="form-group" id="outlet-section" style="{{ $selectedUser->role == 'outlet_manager' ? 'display: block' : 'display: none' }}">
                        <label for="outlet_id">Assign Outlet</label>
                        <select id="outlet_id" name="outlet_id" class="form-control">
                            <option value="">-- Select Outlet --</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}" {{ $selectedUser->outlet_id == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <input type="hidden" name="email" value="{{ request('email') }}">
                    <button type="submit" class="btn btn-primary">Assign Role</button>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            const outletSection = document.getElementById('outlet-section');
            const businessVerification = document.getElementById('business-verification');

            if (this.value === 'outlet_manager') {
                outletSection.style.display = 'block';
                businessVerification.style.display = 'none';
            } else if (this.value === 'business') {
                businessVerification.style.display = 'block';
                outletSection.style.display = 'none';
            } else {
                outletSection.style.display = 'none';
                businessVerification.style.display = 'none';
            }
        });
    </script>
@endsection
