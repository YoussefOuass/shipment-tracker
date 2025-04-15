@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Carriers</h1>
    <!-- Back to Admin Panel Button -->
    <a href="{{ route('carriers.create') }}" class="btn btn-primary mb-3">Add New Carrier</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carriers as $carrier)
                <tr>
                    <td>{{ $carrier->id }}</td>
                    <td>{{ $carrier->name }}</td>
                    <td>{{ $carrier->contact_info }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('carriers.show', $carrier->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('carriers.edit', $carrier->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('carriers.destroy', $carrier->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this carrier?');" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No carriers found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $carriers->links() }}
    </div>
</div>
@endsection