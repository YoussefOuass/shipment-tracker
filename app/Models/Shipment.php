<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'customer_id',
        'carrier_id',
        'origin',
        'destination',
        'estimated_delivery',
        'status',
        'current_latitude',
        'current_longitude',
        'last_location_update',
        'delivery_photo_path',
        'signature_path',
        'delivered_at',
        'qr_code',
        'email_notifications',
        'sms_notifications',
        'phone_number',
        'estimated_cost'
    ];

    protected $casts = [
        'estimated_delivery' => 'datetime',
        'last_location_update' => 'datetime',
        'delivered_at' => 'datetime',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean'
    ];

    // Boot method to generate QR code when creating a new shipment
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($shipment) {
            if (!$shipment->qr_code) {
                $shipment->qr_code = 'SHIP-' . strtoupper(uniqid());
            }
        });
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function carrier() {
        return $this->belongsTo(Carrier::class);
    }

    public function trackingUpdates() {
        return $this->hasMany(TrackingUpdate::class);
    }

    // Generate QR code for the shipment
    public function generateQrCode()
    {
        $url = route('track', ['tracking_number' => $this->tracking_number]);
        return QrCode::size(300)->generate($url);
    }

    // Update shipment location
    public function updateLocation($latitude, $longitude)
    {
        $this->update([
            'current_latitude' => $latitude,
            'current_longitude' => $longitude,
            'last_location_update' => now()
        ]);

        // Send notification if enabled
        if ($this->email_notifications) {
            // Send email notification
            // TODO: Implement email notification
        }

        if ($this->sms_notifications && $this->phone_number) {
            // Send SMS notification
            // TODO: Implement SMS notification
        }
    }

    // Confirm delivery with photo and signature
    public function confirmDelivery($photoPath, $signaturePath)
    {
        $this->update([
            'delivery_photo_path' => $photoPath,
            'signature_path' => $signaturePath,
            'delivered_at' => now(),
            'status' => 'Delivered'
        ]);

        // Create tracking update
        $this->trackingUpdates()->create([
            'status' => 'Delivered',
            'location' => $this->destination,
            'notes' => 'Delivery confirmed with photo and signature'
        ]);

        // Send delivery confirmation notification
        if ($this->email_notifications) {
            // Send email notification
            // TODO: Implement email notification
        }

        if ($this->sms_notifications && $this->phone_number) {
            // Send SMS notification
            // TODO: Implement SMS notification
        }
    }
}
