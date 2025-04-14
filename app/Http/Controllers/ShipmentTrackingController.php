<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ShipmentTrackingController extends Controller
{
    // Update shipment location
    public function updateLocation(Request $request, Shipment $shipment)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $shipment->updateLocation($request->latitude, $request->longitude);

        return response()->json([
            'message' => 'Location updated successfully',
            'shipment' => $shipment
        ]);
    }

    // Confirm delivery with photo and signature
    public function confirmDelivery(Request $request, Shipment $shipment)
    {
        $request->validate([
            'delivery_photo' => 'required|image|max:2048', // Max 2MB
            'signature' => 'required|string', // Base64 encoded signature
        ]);

        // Save delivery photo
        $photoPath = $request->file('delivery_photo')->store('delivery-photos', 'public');
        
        // Save signature
        $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->signature));
        $signaturePath = 'signatures/' . uniqid() . '.png';
        Storage::disk('public')->put($signaturePath, $signatureData);

        // Confirm delivery
        $shipment->confirmDelivery($photoPath, $signaturePath);

        return response()->json([
            'message' => 'Delivery confirmed successfully',
            'shipment' => $shipment
        ]);
    }

    // Get QR code for shipment
    public function getQrCode(Shipment $shipment)
    {
        $qrCode = $shipment->generateQrCode();
        
        return response($qrCode)
            ->header('Content-Type', 'image/png');
    }

    // Update notification preferences
    public function updateNotificationPreferences(Request $request, Shipment $shipment)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $shipment->update($request->only([
            'email_notifications',
            'sms_notifications',
            'phone_number'
        ]));

        return response()->json([
            'message' => 'Notification preferences updated successfully',
            'shipment' => $shipment
        ]);
    }

    // Get shipment location history
    public function getLocationHistory(Shipment $shipment)
    {
        $locationHistory = $shipment->trackingUpdates()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('created_at', 'desc')
            ->get(['latitude', 'longitude', 'created_at']);

        return response()->json([
            'location_history' => $locationHistory
        ]);
    }
} 