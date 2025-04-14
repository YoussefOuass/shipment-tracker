<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // ✅ THIS is what was missing

class ShipmentController extends Controller
{
    public function index()
    {
        return view('track', [
            'shipment' => null,
            'tracking_number' => null
        ]);
    }

    public function track(Request $request)
    {
        $tracking_number = $request->input('tracking_number');

        $shipment = Shipment::with(['customer', 'carrier', 'trackingUpdates' => function ($q) {
            $q->orderBy('updated_at', 'desc');
        }])->where('tracking_number', $tracking_number)->first();

        return view('track', compact('shipment', 'tracking_number'));
    }
}
