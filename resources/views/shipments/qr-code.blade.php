@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Shipment QR Code</h1>
            
            <!-- QR Code Display -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                <img src="data:image/png;base64,{{ $qrCode }}" alt="Shipment QR Code" class="mx-auto">
            </div>

            <!-- Shipment Details -->
            <div class="text-left mb-6">
                <p class="text-sm text-gray-600">Tracking Number: <span class="font-medium text-gray-800">{{ $shipment->tracking_number }}</span></p>
                <p class="text-sm text-gray-600">Status: <span class="font-medium text-gray-800">{{ $shipment->status }}</span></p>
                <p class="text-sm text-gray-600">Carrier: <span class="font-medium text-gray-800">{{ $shipment->carrier->name }}</span></p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col space-y-3">
                <a href="{{ route('shipments.tracking', $shipment) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm text-center">
                    Back to Tracking
                </a>
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                    Print QR Code
                </button>
                <a href="data:image/png;base64,{{ $qrCode }}" download="shipment-{{ $shipment->tracking_number }}-qr.png" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm text-center">
                    Download QR Code
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
        }
        button, a {
            display: none !important;
        }
    }
</style>
@endpush
@endsection 