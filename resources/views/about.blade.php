@extends('layouts.admin')

@section('main-content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center">{{ __('About Us') }}</h3>
                </div>
                <div class="card-body">
                    <p>
                        Welcome to <strong>GasByGas</strong>, Sri Lanka's trusted LP gas distribution service. Our mission is to make gas distribution seamless, reliable, and accessible for all.
                        We provide customers with an easy-to-use platform for online gas requests, real-time delivery tracking, and instant notifications..
                    </p>
                    <p>
                        Established with the vision of revolutionizing the gas distribution industry, we ensure the highest standards of safety, efficiency, and customer satisfaction. Our extensive network of
                        outlets and advanced technology solutions guarantee a smooth experience, whether you're a residential customer or a business organization...
                    </p>
                    <p>
                        <strong>Why Choose Us?</strong>
                    </p>
                    <ul>
                        <li>Convenient online gas requesting system.</li>
                        <li>Real-time delivery tracking and status updates.</li>
                        <li>Reliable customer support and service excellence.</li>
                        <li>Seamless experience for residential and industrial clients.</li>
                    </ul>
                    <p>
                        Thank you for choosing GasByGas. Together, let's power your needs safely and efficiently!
                    </p>
                </div>
                <div class="card-footer text-center">
                    <p><strong>Follow Us</strong></p>
                    <a href="https://facebook.com" target="_blank" class="mx-2 text-primary">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="mx-2 text-danger">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" class="mx-2 text-primary">
                        <i class="fab fa-linkedin fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
