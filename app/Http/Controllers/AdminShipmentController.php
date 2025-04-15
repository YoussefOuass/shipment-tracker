<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Shipment::with(['customer', 'carrier'])
            ->latest()
            ->paginate(10);
        return view('admin.shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $carriers = Carrier::all();
        return view('admin.shipments.create', compact('customers', 'carriers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tracking_number' => 'required|string|unique:shipments',
            'customer_id' => 'required|exists:customers,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'estimated_delivery' => 'required|date',
            'status' => 'required|string|in:Shipment Created,In Transit,Out for Delivery,Delivered',
            'estimated_cost' => 'required|numeric|min:0',
            'phone_number' => 'nullable|string|max:20',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shipment = Shipment::create([
            'tracking_number' => $request->tracking_number,
            'customer_id' => $request->customer_id,
            'carrier_id' => $request->carrier_id,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'estimated_delivery' => $request->estimated_delivery,
            'status' => $request->status,
            'estimated_cost' => $request->estimated_cost,
            'phone_number' => $request->phone_number,
            'email_notifications' => $request->boolean('email_notifications', false),
            'sms_notifications' => $request->boolean('sms_notifications', false),
        ]);

        return redirect()->route('shipments.index')
            ->with('success', 'Shipment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        $shipment->load(['customer', 'carrier', 'trackingUpdates']);
        return view('admin.shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        $customers = Customer::all();
        $carriers = Carrier::all();
        return view('admin.shipments.edit', compact('shipment', 'customers', 'carriers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipment $shipment)
    {
        $validator = Validator::make($request->all(), [
            'tracking_number' => 'required|string|unique:shipments,tracking_number,' . $shipment->id,
            'customer_id' => 'required|exists:customers,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'estimated_delivery' => 'required|date',
            'status' => 'required|string|in:Shipment Created,In Transit,Out for Delivery,Delivered',
            'estimated_cost' => 'required|numeric|min:0',
            'phone_number' => 'nullable|string|max:20',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shipment->update([
            'tracking_number' => $request->tracking_number,
            'customer_id' => $request->customer_id,
            'carrier_id' => $request->carrier_id,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'estimated_delivery' => $request->estimated_delivery,
            'status' => $request->status,
            'estimated_cost' => $request->estimated_cost,
            'phone_number' => $request->phone_number,
            'email_notifications' => $request->boolean('email_notifications', false),
            'sms_notifications' => $request->boolean('sms_notifications', false),
        ]);

        return redirect()->route('shipments.index')
            ->with('success', 'Shipment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('shipments.index')
            ->with('success', 'Shipment deleted successfully');
    }
} 