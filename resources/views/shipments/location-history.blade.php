@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Location History</h1>
                <a href="{{ route('shipments.tracking', $shipment) }}" class="text-blue-500 hover:text-blue-600">
                    Back to Tracking
                </a>
            </div>

            <!-- Shipment Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Map -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-lg p-4 h-[600px]">
                        <div id="map" class="w-full h-full rounded-lg"></div>
                    </div>
                </div>

                <!-- Location Timeline -->
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-800">Location Timeline</h2>
                    <div class="space-y-4">
                        @foreach($locations as $location)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $location->address }}</p>
                                        <p class="text-sm text-gray-600">{{ $location->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    <button onclick="centerMap({{ $location->latitude }}, {{ $location->longitude }})" 
                                        class="text-blue-500 hover:text-blue-600 text-sm">
                                        View on Map
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    let map;
    let markers = [];
    const locations = @json($locations);

    function initMap() {
        // Initialize map
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: { lat: 0, lng: 0 },
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }
            ]
        });

        // Add markers for each location
        locations.forEach((location, index) => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
                map: map,
                title: location.address,
                label: {
                    text: (index + 1).toString(),
                    color: 'white'
                }
            });

            // Add info window
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div class="p-2">
                        <p class="font-medium">${location.address}</p>
                        <p class="text-sm text-gray-600">${new Date(location.created_at).toLocaleString()}</p>
                    </div>
                `
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });

            markers.push(marker);
        });

        // Draw path between markers
        if (markers.length > 1) {
            const path = new google.maps.Polyline({
                path: markers.map(marker => marker.getPosition()),
                geodesic: true,
                strokeColor: '#3B82F6',
                strokeOpacity: 0.8,
                strokeWeight: 3
            });
            path.setMap(map);

            // Fit map to show all markers
            const bounds = new google.maps.LatLngBounds();
            markers.forEach(marker => bounds.extend(marker.getPosition()));
            map.fitBounds(bounds);
        }
    }

    function centerMap(lat, lng) {
        map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
        map.setZoom(12);
    }

    // Initialize map when the page loads
    window.addEventListener('load', initMap);
</script>
@endpush
@endsection 