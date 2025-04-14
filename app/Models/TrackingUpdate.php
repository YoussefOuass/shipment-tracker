<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'status',
        'location',
        'notes'
    ];

    public function shipment() {
        return $this->belongsTo(Shipment::class);
    }
    
}
