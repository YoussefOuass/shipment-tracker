@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Shipment Tracking</h1>
            <div class="flex space-x-4">
                <button onclick="window.print()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <a href="{{ route('shipments.qr-code', $shipment) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-qrcode mr-2"></i>QR Code
                </a>
            </div>
        </div>

        <!-- Shipment Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Shipment Information</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Tracking Number:</span> {{ $shipment->tracking_number }}</p>
                    <p><span class="font-medium">Status:</span> 
                        <span class="px-2 py-1 rounded-full text-sm 
                            @if($shipment->status === 'Delivered') bg-green-100 text-green-800
                            @elseif($shipment->status === 'In Transit') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $shipment->status }}
                        </span>
                    </p>
                    <p><span class="font-medium">Carrier:</span> {{ $shipment->carrier->name }}</p>
                    <p><span class="font-medium">Estimated Delivery:</span> {{ $shipment->estimated_delivery->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Location Details</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Origin:</span> {{ $shipment->origin }}</p>
                    <p><span class="font-medium">Destination:</span> {{ $shipment->destination }}</p>
                    <p><span class="font-medium">Current Location:</span> {{ $shipment->current_location ?? 'Not available' }}</p>
                    <p><span class="font-medium">Last Updated:</span> {{ $shipment->last_location_update ? $shipment->last_location_update->format('M d, Y H:i') : 'Not available' }}</p>
                </div>
            </div>
        </div>

        <!-- Tracking Timeline -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Tracking History</h2>
            <div class="relative">
                @foreach($shipment->trackingUpdates as $update)
                <div class="flex items-start mb-6">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white z-10">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium">{{ $update->status }}</h3>
                            <span class="text-sm text-gray-500">{{ $update->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <p class="text-gray-600">{{ $update->location }}</p>
                        @if($update->notes)
                        <p class="text-sm text-gray-500 mt-1">{{ $update->notes }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Delivery Confirmation -->
        @if($shipment->status === 'Delivered')
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Delivery Confirmation</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($shipment->delivery_photo_path)
                <div>
                    <h3 class="font-medium mb-2">Delivery Photo</h3>
                    <img src="{{ asset('storage/' . $shipment->delivery_photo_path) }}" alt="Delivery Photo" class="rounded-lg w-full">
                </div>
                @endif
                @if($shipment->signature_path)
                <div>
                    <h3 class="font-medium mb-2">Signature</h3>
                    <img src="{{ asset('storage/' . $shipment->signature_path) }}" alt="Signature" class="rounded-lg w-full">
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Notification Preferences -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Notification Preferences</h2>
            <form action="{{ route('shipments.notification-preferences', $shipment) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="flex items-center">
                    <input type="checkbox" name="email_notifications" id="email_notifications" 
                           {{ $shipment->email_notifications ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 rounded border-gray-300">
                    <label for="email_notifications" class="ml-2">Email Notifications</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="sms_notifications" id="sms_notifications" 
                           {{ $shipment->sms_notifications ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 rounded border-gray-300">
                    <label for="sms_notifications" class="ml-2">SMS Notifications</label>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Update Preferences
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 