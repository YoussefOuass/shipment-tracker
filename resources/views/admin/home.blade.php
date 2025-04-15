@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <!-- Dashboard Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Shipments</h5>
                    <p class="card-text">{{ $shipments->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Carriers</h5>
                    <p class="card-text">{{ $carriers->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $users->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <p class="card-text">{{ $customers->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipments and Carriers Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Shipments</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($shipments as $shipment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $shipment->tracking_number }} - {{ $shipment->status }}
                                <span class="badge bg-info text-dark">{{ $shipment->status }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">No shipments found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5>Carriers</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($carriers as $carrier)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $carrier->name }}
                                <span class="text-muted">{{ $carrier->contact_info }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">No carriers found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Users and Customers Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5>Users</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($users as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $user->name }}
                                <span class="text-muted">{{ $user->email }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">No users found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5>Customers</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($customers as $customer)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $customer->name }}
                                <span class="text-muted">{{ $customer->email }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">No customers found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection