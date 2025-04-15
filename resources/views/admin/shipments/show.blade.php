shipment-tracker\resources\views\admin\shipments\show.blade.php
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Shipment Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $shipment->id }}</p>
            <p><strong>Tracking Number:</strong> {{ $shipment->tracking_number }}</p>
            <p><strong>Status:</strong> {{ $shipment->status }}</p>
            <p><strong>Created At:</strong> {{ $shipment->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
    <a href="{{ route('shipments.index') }}" class="btn btn-secondary mt-3">Back to Shipments</a>
</div>
@endsection