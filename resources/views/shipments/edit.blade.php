@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Shipment</h1>
                <a href="{{ route('shipments.show', $shipment) }}" class="text-blue-500 hover:text-blue-600">
                    Back to Details
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('shipments.update', $shipment) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="tracking_number" class="block text-sm font-medium text-gray-700">Tracking Number</label>
                            <input type="text" id="tracking_number" value="{{ $shipment->tracking_number }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="Pending" {{ $shipment->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Transit" {{ $shipment->status === 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                <option value="Delivered" {{ $shipment->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Cancelled" {{ $shipment->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div>
                            <label for="carrier" class="block text-sm font-medium text-gray-700">Carrier</label>
                            <input type="text" id="carrier" value="{{ $shipment->carrier->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="origin" class="block text-sm font-medium text-gray-700">Origin</label>
                            <input type="text" name="origin" id="origin" value="{{ $shipment->origin }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label for="destination" class="block text-sm font-medium text-gray-700">Destination</label>
                            <input type="text" name="destination" id="destination" value="{{ $shipment->destination }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label for="estimated_delivery" class="block text-sm font-medium text-gray-700">Estimated Delivery</label>
                            <input type="datetime-local" name="estimated_delivery" id="estimated_delivery" value="{{ $shipment->estimated_delivery->format('Y-m-d\TH:i') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <!-- Notification Preferences -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="email_notifications" id="email_notifications" value="1" {{ $shipment->email_notifications ? 'checked' : '' }} class="h-4 w-4 text-blue-600 rounded border-gray-300">
                            <label for="email_notifications" class="ml-2 block text-sm text-gray-700">Email Notifications</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="sms_notifications" id="sms_notifications" value="1" {{ $shipment->sms_notifications ? 'checked' : '' }} class="h-4 w-4 text-blue-600 rounded border-gray-300">
                            <label for="sms_notifications" class="ml-2 block text-sm text-gray-700">SMS Notifications</label>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ $shipment->phone_number }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('shipments.show', $shipment) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Update Shipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 