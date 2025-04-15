<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Carrier;
use App\Models\User;
use App\Models\Customer;

class AdminController extends Controller
{
    public function index()
    {
        $shipments = Shipment::all();
        $carriers = Carrier::all();
        $users = User::all();
        $customers = Customer::all();

        return view('admin.home', compact('shipments', 'carriers', 'users', 'customers'));
    }

    public function home()
    {
        return $this->index(); // Reuse the index method to load the same data and view
    }
}
