<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index()
    {
        $data = [
            'totalShipments' => Shipment::count(),
            'activeShipments' => Shipment::where('status', '!=', 'delivered')->count(),
            'totalUsers' => User::count(),
            'recentShipments' => Shipment::with('customer')
                ->latest()
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', $data);
    }
}


// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Shipment;
// use App\Models\User;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         return view('admin.dashboard', [
//             'shipments' => Shipment::latest()->take(10)->get(),
//             'shipmentCount' => Shipment::count(),
//             'userCount' => User::count()
//         ]);
//     }
// }

