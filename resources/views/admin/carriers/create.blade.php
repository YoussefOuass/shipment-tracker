@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Carrier</h1>
    <form action="{{ route('carriers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contact_info">Contact Info</label>
            <input type="text" name="contact_info" id="contact_info" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" name="code" id="code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Add Carrier</button>
    </form>
</div>
@endsection