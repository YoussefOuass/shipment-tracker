@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Carrier</h1>
    <form action="{{ route('carriers.update', $carrier->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $carrier->name }}" required>
        </div>
        <div class="form-group">
            <label for="contact_info">Contact Info</label>
            <input type="text" name="contact_info" id="contact_info" class="form-control" value="{{ $carrier->contact_info }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection