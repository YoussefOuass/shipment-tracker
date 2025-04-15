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

        if ($user->is_admin) {
            // Fetch data for admin
            $shipments = Shipment::all();
            $carriers = \App\Models\Carrier::all();
            $users = \App\Models\User::all();
            $customers = Customer::all();

            return view('admin.dashboard', compact('shipments', 'carriers', 'users', 'customers'));
        }

        // Fetch data for regular user
        $customer = Customer::where('email', $user->email)->first();

        if (!$customer) {
            return view('dashboard', [
                'shipments' => collect([]),
                'userShipments' => 0,
                'inTransitCount' => 0,
                'deliveredCount' => 0,
            ]);
        }

        $shipments = Shipment::where('customer_id', $customer->id)->get();

        return view('dashboard', compact('shipments'));
    }

    public function redirectToHome()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard'); // Redirect admins to the admin dashboard
        }

        return redirect()->route('dashboard'); // Redirect regular users to their dashboard
    }
}