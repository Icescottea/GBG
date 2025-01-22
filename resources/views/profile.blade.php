@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Profile Management') }}</h1>

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

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Profile Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('home') }}" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label for="name">Name<span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name ?? 'guest') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address<span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email ?? 'guest' ) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? 'guest' ) }}">
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" class="form-control">{{ old('address', Auth::user()->address ?? 'guest' ) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter current password">
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Delete Account</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('home') }}">
                        @csrf
                        @method('DELETE')
                        <p>Deleting your account is a permanent action and cannot be undone. Proceed with caution.</p>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                                Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
