<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_info'
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
