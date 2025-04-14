@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">📦 Shipment Tracker</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('track') }}" class="mb-4">
            <div class="flex gap-4">
                <input type="text" 
                       name="tracking_number" 
                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                       placeholder="Enter Tracking Number" 
                       value="{{ $tracking_number ?? '' }}">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Track
                </button>
            </div>
        </form>

        @if(isset($shipment) && $shipment)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-800 text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Tracking #: {{ $shipment->tracking_number }}</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Customer Information</h3>
                            <p class="text-gray-600">{{ $shipment->customer->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Carrier</h3>
                            <p class="text-gray-600">{{ $shipment->carrier->name }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Route</h3>
                        <p class="text-gray-600">From: {{ $shipment->origin }} → To: {{ $shipment->destination }}</p>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Estimated Delivery</h3>
                        <p class="text-blue-600">
                            {{ \Carbon\Carbon::parse($shipment->estimated_delivery)->diffForHumans() }}
                        </p>
                    </div>

                    <!-- QR Code Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">QR Code</h3>
                        <div class="flex items-center justify-center">
                            <img src="{{ route('shipments.qr-code', $shipment) }}" alt="QR Code" class="w-32 h-32">
                        </div>
                        <p class="text-sm text-gray-500 text-center mt-2">Scan to track this shipment</p>
                    </div>

                    <!-- Current Location Section -->
                    @if($shipment->current_latitude && $shipment->current_longitude)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Current Location</h3>
                        <div id="map" class="h-64 bg-gray-200 rounded-lg mb-2"></div>
                        <p class="text-sm text-gray-500">
                            Last updated: {{ $shipment->last_location_update->diffForHumans() }}
                        </p>
                    </div>
                    @endif

                    @php
                        $statuses = ['Shipment Created', 'In Transit', 'Out for Delivery', 'Delivered'];
                        $currentStatus = $shipment->trackingUpdates->first()->status ?? 'Shipment Created';
                        $progress = array_search($currentStatus, $statuses) !== false ? ((array_search($currentStatus, $statuses)+1)/count($statuses))*100 : 0;
                        $isDelayed = $shipment->trackingUpdates->first()?->status === 'Delayed';
                    @endphp

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Current Status</h3>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="h-4 rounded-full {{ $isDelayed ? 'bg-red-500' : 'bg-green-500' }}" 
                                 style="width: {{ $progress }}%;">
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">{{ $currentStatus }}</p>
                    </div>

                    <!-- Delivery Confirmation Section -->
                    @if($shipment->status === 'Out for Delivery')
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Delivery Confirmation</h3>
                        <form id="deliveryForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Delivery Photo</label>
                                <input type="file" name="delivery_photo" accept="image/*" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Signature</label>
                                <div id="signaturePad" class="border border-gray-300 rounded-md h-32"></div>
                                <button type="button" id="clearSignature" class="mt-2 text-sm text-blue-500">Clear Signature</button>
                            </div>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Confirm Delivery
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- Notification Preferences -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Notification Preferences</h3>
                        <form id="notificationForm" class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="email_notifications" id="email_notifications" 
                                       {{ $shipment->email_notifications ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="email_notifications" class="ml-2 block text-sm text-gray-700">
                                    Email Notifications
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="sms_notifications" id="sms_notifications"
                                       {{ $shipment->sms_notifications ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="sms_notifications" class="ml-2 block text-sm text-gray-700">
                                    SMS Notifications
                                </label>
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" name="phone_number" id="phone_number" 
                                       value="{{ $shipment->phone_number }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Preferences
                            </button>
                        </form>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Status History</h3>
                        <div class="space-y-3">
                            @foreach($shipment->trackingUpdates as $update)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                    <div>
                                        <p class="font-medium">{{ $update->status }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $update->updated_at->format('Y-m-d H:i') }} at {{ $update->location }}
                                        </p>
                                    </div>
                                    @if($update->status === 'Delayed')
                                        <span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">
                                            Delayed
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @elseif(isset($tracking_number))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                Tracking number not found.
            </div>
        @endif
    </div>
</div>

@if(isset($shipment) && $shipment && $shipment->current_latitude && $shipment->current_longitude)
<!-- Google Maps JavaScript -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
<script>
    function initMap() {
        const location = { 
            lat: {{ $shipment->current_latitude }}, 
            lng: {{ $shipment->current_longitude }} 
        };
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: location
        });
        const marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
    initMap();
</script>
@endif

<!-- Signature Pad JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($shipment) && $shipment)
        const signaturePad = new SignaturePad(document.getElementById('signaturePad'), {
            backgroundColor: 'rgb(255, 255, 255)'
        });

        document.getElementById('clearSignature').addEventListener('click', function() {
            signaturePad.clear();
        });

        // Handle delivery confirmation form submission
        const deliveryForm = document.getElementById('deliveryForm');
        if (deliveryForm) {
            deliveryForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData();
                formData.append('delivery_photo', this.querySelector('input[type="file"]').files[0]);
                formData.append('signature', signaturePad.toDataURL());

                try {
                    const response = await fetch(`/shipments/{{ $shipment->id }}/confirm-delivery`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Error confirming delivery');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error confirming delivery');
                }
            });
        }

        // Handle notification preferences form submission
        const notificationForm = document.getElementById('notificationForm');
        if (notificationForm) {
            notificationForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                try {
                    const response = await fetch(`/shipments/{{ $shipment->id }}/notification-preferences`, {
                        method: 'PUT',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        alert('Notification preferences updated successfully');
                    } else {
                        alert('Error updating notification preferences');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error updating notification preferences');
                }
            });
        }
        @endif
    });
</script>
@endsection
