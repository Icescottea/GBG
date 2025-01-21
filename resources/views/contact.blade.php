@extends('layouts.admin')

@section('main-content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="text-center">{{ __('Contact Us') }}</h3>
                </div>
                <div class="card-body">
                    <p>
                        We’re here to help! If you have any questions, concerns, or need assistance, feel free to reach out to us using the contact information below. Our team is dedicated to providing you with the best possible service.
                    </p>
                    <p>
                        <strong>Head Office:</strong><br>
                        GasByGas<br>
                        No. 123, Main Street,<br>
                        Colombo 01, Sri Lanka.
                    </p>
                    <p>
                        <strong>Contact Information:</strong><br>
                        Phone: +94 11 123 4567<br>
                        Email: <a href="mailto:support@gasbygas.com">support@gasbygas.com</a><br>
                        Website: <a href="https://www.gasbygas.com" target="_blank">www.gasbygas.com</a>
                    </p>
                    <p>
                        <strong>Business Hours:</strong><br>
                        Monday to Friday: 8:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 4:00 PM<br>
                        Sunday: Closed
                    </p>
                    <p>
                        Thank you for choosing GasByGas. We look forward to assisting you!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
