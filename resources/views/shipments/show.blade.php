@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Shipment Details</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('shipments.edit', $shipment) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Edit Shipment
                    </a>
                    <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this shipment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            Delete Shipment
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold mb-4">Basic Information</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Tracking Number</p>
                            <p class="font-medium">{{ $shipment->tracking_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-medium">{{ $shipment->status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Carrier</p>
                            <p class="font-medium">{{ $shipment->carrier->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Estimated Delivery</p>
                            <p class="font-medium">{{ $shipment->estimated_delivery->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold mb-4">Location Information</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Origin</p>
                            <p class="font-medium">{{ $shipment->origin }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Destination</p>
                            <p class="font-medium">{{ $shipment->destination }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Current Location</p>
                            <p class="font-medium">
                                @if($shipment->current_latitude && $shipment->current_longitude)
                                    {{ $shipment->current_latitude }}, {{ $shipment->current_longitude }}
                                @else
                                    Not available
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Notification Preferences -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold mb-4">Notification Preferences</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Email Notifications</p>
                            <p class="font-medium">{{ $shipment->email_notifications ? 'Enabled' : 'Disabled' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">SMS Notifications</p>
                            <p class="font-medium">{{ $shipment->sms_notifications ? 'Enabled' : 'Disabled' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone Number</p>
                            <p class="font-medium">{{ $shipment->phone_number ?? 'Not set' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tracking Updates -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold mb-4">Recent Tracking Updates</h2>
                    <div class="space-y-3">
                        @forelse($shipment->trackingUpdates as $update)
                            <div class="border-b pb-2">
                                <p class="text-sm text-gray-600">{{ $update->created_at->format('M d, Y H:i') }}</p>
                                <p class="font-medium">{{ $update->status }}</p>
                                @if($update->location)
                                    <p class="text-sm">{{ $update->location }}</p>
                                @endif
                                @if($update->notes)
                                    <p class="text-sm text-gray-600">{{ $update->notes }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-600">No tracking updates available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 