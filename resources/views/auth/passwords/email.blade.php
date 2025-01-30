@extends('layouts.auth')

@section('main-content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="{{ asset('img/logo.jpeg') }}" class="img-fluid" alt="Login Image">
                        </div>
                        <div class="col-lg-6 d-flex align-items-center justify-content-center">
                            <div class="p-5 text-center">
                                <h1 class="h4 text-gray-900 mb-4">{{ __('Find Your Admin and Ask For Help') }}</h1>

                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="alert alert-success border-left-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">
                                        {{ __('Back to Login') }}
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
@endsection
