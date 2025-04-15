@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>User Details</h2>
                        <div>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-info">Edit</a>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p>{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p>{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role:</label>
                        <p>
                            @if($user->is_admin)
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p>{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Last Updated:</label>
                        <p>{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 