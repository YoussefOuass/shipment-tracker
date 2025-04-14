@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Confirm Delivery</h1>
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

            <form action="{{ route('shipments.confirm-delivery', $shipment) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Delivery Photo -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Delivery Photo</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 5MB)</p>
                                </div>
                                <input type="file" name="delivery_photo" class="hidden" accept="image/*" required />
                            </label>
                        </div>
                        @error('delivery_photo')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Signature -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Recipient Signature</h3>
                    <div class="space-y-4">
                        <div class="border-2 border-gray-300 rounded-lg">
                            <canvas id="signatureCanvas" class="w-full h-48 bg-white"></canvas>
                            <input type="hidden" name="signature" id="signatureData">
                        </div>
                        <div class="flex justify-between">
                            <button type="button" id="clearSignature" class="text-gray-600 hover:text-gray-800">
                                Clear Signature
                            </button>
                            <p class="text-sm text-gray-500">Please sign in the box above</p>
                        </div>
                        @error('signature')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Delivery Notes</h3>
                    <div class="space-y-4">
                        <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            placeholder="Add any additional notes about the delivery..."></textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Confirm Delivery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('signatureCanvas');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)'
        });

        // Handle window resize
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        // Clear signature
        document.getElementById('clearSignature').addEventListener('click', function() {
            signaturePad.clear();
        });

        // Save signature before form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                alert('Please provide a signature');
                return;
            }
            document.getElementById('signatureData').value = signaturePad.toDataURL();
        });
    });
</script>
@endpush
@endsection 