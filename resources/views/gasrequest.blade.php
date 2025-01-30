@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Gas Request') }}</h1>

    <!-- Error Display -->
    @if ($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('gasrequest.store') }}" method="POST">
        @csrf

        <!-- Outlet Selection -->
        <div class="form-group">
            <label for="outlet_id">{{ __('Select Outlet') }}</label>
            <select name="outlet_id" id="outlet_id" class="form-control" required>
                <option value="" disabled selected>-- Select Outlet --</option>
                @foreach ($outlets as $outlet)
                    <option value="{{ $outlet->id }}">{{ $outlet->name }} ({{ $outlet->location }})</option>
                @endforeach
            </select>
        </div>

        <!-- Cylinder Type -->
        <div class="form-group">
            <label for="type">{{ __('Cylinder Type') }}</label>
            <select name="type" id="type" class="form-control" required>
                <option value="" disabled selected>-- Select Type --</option>
                <option value="5kg">5kg</option>
                <option value="12kg">12kg</option>
            </select>
        </div>

        <!-- Quantity Selection (Limit Based on User Role) -->
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control"
                min="1"
                max="{{ auth()->user()->role === 'business' ? 10 : 2 }}"
                required>
        </div>

        <!-- Submit Button -->
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">{{ __('Submit Request') }}</button>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let quantityInput = document.getElementById('quantity');
    
            // Get max limit dynamically
            let maxLimit = parseInt("{{ auth()->user()->role === 'business' ? 10 : 2 }}", 10);
    
            quantityInput.addEventListener('input', function() {
                if (this.value > maxLimit) {
                    this.value = maxLimit; // Reset to max allowed
                }
            });
        });
    </script>    
    
@endsection


