@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">My Active Tokens</h1>

<div class="card mb-4">
    <div class="card-header">Active Tokens</div>
    <div class="card-body">
        @if ($tokens->isEmpty())
            <p>No active tokens available.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Token Code</th>
                        <th>Outlet</th>
                        <th>Status</th>
                        <th>Expires On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tokens as $token)
                        <tr>
                            <td>{{ $token->token_code }}</td>
                            <td>{{ $token->outlet->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($token->status) }}</td>
                            <td>
                                @if ($token->expires_at)
                                    {{ $token->expires_at->format('Y-m-d') }}
                                @else
                                    <span class="text-danger">No Expiration Date</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
