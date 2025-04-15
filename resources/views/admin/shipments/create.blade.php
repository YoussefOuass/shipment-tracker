@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Create New Shipment</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('shipments.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                                id="tracking_number" name="tracking_number" value="{{ old('tracking_number') }}" required>
                            @error('tracking_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select @error('customer_id') is-invalid @enderror" 
                                id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach(\App\Models\Customer::all() as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="carrier_id" class="form-label">Carrier</label>
                            <select class="form-select @error('carrier_id') is-invalid @enderror" 
                                id="carrier_id" name="carrier_id" required>
                                <option value="">Select Carrier</option>
                                @foreach(\App\Models\Carrier::all() as $carrier)
                                    <option value="{{ $carrier->id }}" {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                                        {{ $carrier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('carrier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="origin" class="form-label">Origin</label>
                            <input type="text" class="form-control @error('origin') is-invalid @enderror" 
                                id="origin" name="origin" value="{{ old('origin') }}" required>
                            @error('origin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="destination" class="form-label">Destination</label>
                            <input type="text" class="form-control @error('destination') is-invalid @enderror" 
                                id="destination" name="destination" value="{{ old('destination') }}" required>
                            @error('destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estimated_delivery" class="form-label">Estimated Delivery</label>
                            <input type="datetime-local" class="form-control @error('estimated_delivery') is-invalid @enderror" 
                                id="estimated_delivery" name="estimated_delivery" 
                                value="{{ old('estimated_delivery') }}" required>
                            @error('estimated_delivery')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Shipment Created" {{ old('status') == 'Shipment Created' ? 'selected' : '' }}>Shipment Created</option>
                                <option value="In Transit" {{ old('status') == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                <option value="Out for Delivery" {{ old('status') == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                <option value="Delivered" {{ old('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estimated_cost" class="form-label">Estimated Cost</label>
                            <input type="number" step="0.01" class="form-control @error('estimated_cost') is-invalid @enderror" 
                                id="estimated_cost" name="estimated_cost" value="{{ old('estimated_cost') }}" required>
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Contact Phone Number</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="email_notifications" 
                                    name="email_notifications" value="1" {{ old('email_notifications') ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">Enable Email Notifications</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="sms_notifications" 
                                    name="sms_notifications" value="1" {{ old('sms_notifications') ? 'checked' : '' }}>
                                <label class="form-check-label" for="sms_notifications">Enable SMS Notifications</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Shipment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 