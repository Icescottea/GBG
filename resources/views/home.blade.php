@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center">{{ __('Welcome to GasByGas') }}</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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

    <!-- Company Introduction -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary text-center">Your Trusted Partner in Gas Supply</h5>
                </div>
                <div class="card-body text-center">
                    <p>At GasByGas, we believe in delivering safe, reliable, and efficient gas solutions to homes and businesses across Sri Lanka. 
                        With a commitment to excellence and innovation, we have streamlined the process of gas ordering, ensuring seamless 
                        transactions and timely deliveries. Our advanced system keeps you updated on stock availability, request approvals, and 
                        scheduled deliveries, so you can focus on what truly matters.</p>

                    <p>Whether you are a household in need of a reliable cooking gas supply or a business looking for a consistent bulk gas 
                        provider, we’ve got you covered. Our customer-first approach guarantees satisfaction, making gas procurement hassle-free and 
                        efficient.</p>

                    <p>Experience the future of gas distribution with GasByGas, where convenience meets reliability.</p>
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
