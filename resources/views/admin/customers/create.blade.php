@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Customer</h1>
    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success mt-3">Create Customer</button>
    </form>
</div>
@endsection