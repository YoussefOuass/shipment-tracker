<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // ✅ THIS is what was missing

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::paginate(10);
        return view('admin.shipments.index', compact('shipments'));
    }

    public function track(Request $request)
    {
        $tracking_number = $request->input('tracking_number');

        $shipment = Shipment::with(['customer', 'carrier', 'trackingUpdates' => function ($q) {
            $q->orderBy('updated_at', 'desc');
        }])->where('tracking_number', $tracking_number)->first();

        return view('track', compact('shipment', 'tracking_number'));
    }

    public function show(Shipment $shipment)
    {
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $shipment->update($request->only('tracking_number', 'status'));

        return redirect()->route('shipments.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('shipments.index')->with('success', 'Shipment deleted successfully.');
    }
}
