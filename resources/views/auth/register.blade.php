@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-light">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('img/logo.jpeg') }}" class="img-fluid" style="max-height: 100%;" alt="Register Image">
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Register') }}</h1>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Registration Type Selection -->
                                <div class="form-group text-center">
                                    <label><strong>Register as:</strong></label>
                                    <div>
                                        <button type="button" class="btn btn-primary" id="registerCustomer">Regular Customer</button>
                                        <button type="button" class="btn btn-warning" id="registerBusiness">Business</button>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('register') }}" class="user" enctype="multipart/form-data">
                                    @csrf <!-- CSRF Token for security -->

                                    <!-- NIC Field -->
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="id" placeholder="{{ __('NIC') }}" value="{{ old('id') }}" required>
                                    </div>

                                    <!-- Name Field -->
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required>
                                    </div>

                                    <!-- Phone Field -->
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="phone" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required>
                                    </div>

                                    <!-- Address Field -->
                                    <div class="form-group">
                                        <textarea class="form-control form-control-user" name="address" placeholder="{{ __('Address') }}" required>{{ old('address') }}</textarea>
                                    </div>

                                    <!-- Certificate Upload (Hidden Initially) -->
                                    <div class="form-group" id="certificateSection" style="display: none;">
                                        <label for="certificate">Upload Business Certificate</label>
                                        <input type="file" class="form-control" name="certificate">
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="{{ __('Password') }}" required>
                                    </div>

                                    <!-- Confirm Password Field -->
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                                    </div>

                                    <input type="hidden" name="role" id="role" value="customer">

                                    <!-- Submit Button -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </form>

                                <hr>

                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">
                                        {{ __('Already have an account? Login!') }}
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerCustomer').addEventListener('click', function() {
        document.getElementById('certificateSection').style.display = 'none';
        document.getElementById('role').value = 'customer';
    });
    
    document.getElementById('registerBusiness').addEventListener('click', function() {
        document.getElementById('certificateSection').style.display = 'block';
        document.getElementById('role').value = 'business';
    });
</script>

@endsection
