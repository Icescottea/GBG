@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Welcome to GasByGas') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <!-- Feature 1 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body text-center">
                    <i class="fas fa-gas-pump fa-3x text-primary mb-3"></i>
                    <h5 class="text-primary">Gas Requests</h5>
                    <p>Easily request gas cylinders online with real-time tracking.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Request Now</a>
                </div>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body text-center">
                    <i class="fas fa-bell fa-3x text-success mb-3"></i>
                    <h5 class="text-success">Notifications</h5>
                    <p>Stay updated with SMS and email notifications for your requests.</p>
                    <a href="{{ route('home') }}" class="btn btn-success">Learn More</a>
                </div>
            </div>
        </div>

        <!-- Feature 3 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-3x text-info mb-3"></i>
                    <h5 class="text-info">Delivery Tracking</h5>
                    <p>Track gas deliveries to your preferred outlets in real-time.</p>
                    <a href="{{ route('home') }}" class="btn btn-info">Track Now</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <!-- About Us Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">About Us</h6>
                </div>
                <div class="card-body">
                    <p>GasByGas is a leading LP gas distribution service in Sri Lanka, providing seamless online gas requests, notifications, and delivery tracking services across the island.</p>
                    <a href="{{ route('about') }}" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>

        <!-- Contact Us Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contact Us</h6>
                </div>
                <div class="card-body">
                    <p>Need help or have questions? Reach out to our support team.</p>
                    <a href="{{ route('contact') }}" class="btn btn-primary">Get in Touch</a>
                </div>
            </div>
        </div>
    </div>
@endsection
