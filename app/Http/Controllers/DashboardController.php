<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Find the customer associated with the user
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            // If no customer is found, return empty data
            return view('dashboard', [
                'shipments' => collect([]),
                'userShipments' => 0,
                'inTransitCount' => 0,
                'deliveredCount' => 0
            ]);
        }
        
        // Get customer's shipments
        $shipments = Shipment::where('customer_id', $customer->id)
            ->latest()
            ->take(10)
            ->get();
            
        // Count customer's shipments
        $userShipments = Shipment::where('customer_id', $customer->id)->count();
        
        // Count in-transit shipments
        $inTransitCount = Shipment::where('customer_id', $customer->id)
            ->where('status', 'In Transit')
            ->count();
            
        // Count delivered shipments
        $deliveredCount = Shipment::where('customer_id', $customer->id)
            ->where('status', 'Delivered')
            ->count();
        
        return view('dashboard', [
            'shipments' => $shipments,
            'userShipments' => $userShipments,
            'inTransitCount' => $inTransitCount,
            'deliveredCount' => $deliveredCount
        ]);
    }
} 