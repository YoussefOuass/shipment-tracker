@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Carrier Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $carrier->id }}</p>
            <p><strong>Name:</strong> {{ $carrier->name }}</p>
            <p><strong>Contact Info:</strong> {{ $carrier->contact_info }}</p>
        </div>
    </div>
    <a href="{{ route('carriers.index') }}" class="btn btn-secondary mt-3">Back to Carriers</a>
</div>
@endsection