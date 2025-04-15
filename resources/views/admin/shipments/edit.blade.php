@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Shipment</h1>
    <form action="{{ route('shipments.update', $shipment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tracking_number">Tracking Number</label>
            <input type="text" name="tracking_number" id="tracking_number" class="form-control" value="{{ $shipment->tracking_number }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" id="status" class="form-control" value="{{ $shipment->status }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection