@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Manage Shipments</h2>
                        <a href="{{ route('shipments.create') }}" class="btn btn-primary">Add New Shipment</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tracking Number</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shipments as $shipment)
                                <tr>
                                    <td>{{ $shipment->id }}</td>
                                    <td>{{ $shipment->tracking_number }}</td>
                                    <td>{{ $shipment->status }}</td>
                                    <td>{{ $shipment->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('shipments.show', $shipment->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipment?');" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No shipments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $shipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection