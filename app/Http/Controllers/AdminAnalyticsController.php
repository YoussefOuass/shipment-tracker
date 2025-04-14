<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Carrier;
use App\Models\Customer;
use App\Models\TrackingUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        // Get data for the dashboard
        $revenueData = $this->getRevenueData();
        $carrierPerformance = $this->getCarrierPerformance();
        $customerSegments = $this->getCustomerSegments();
        $inventoryStatus = $this->getInventoryStatus();
        
        return view('admin.analytics', compact(
            'revenueData',
            'carrierPerformance',
            'customerSegments',
            'inventoryStatus'
        ));
    }
    
    private function getRevenueData()
    {
        // Get revenue data for the last 30 days
        $revenueData = Shipment::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_shipments'),
            DB::raw('SUM(estimated_cost) as total_revenue')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        return $revenueData;
    }
    
    private function getCarrierPerformance()
    {
        // Get carrier performance metrics
        $carrierPerformance = Carrier::select('carriers.name', 'carriers.code')
            ->selectRaw('COUNT(shipments.id) as total_shipments')
            ->selectRaw('AVG(CASE WHEN tracking_updates.status = "Delayed" THEN 1 ELSE 0 END) * 100 as delay_percentage')
            ->leftJoin('shipments', 'carriers.id', '=', 'shipments.carrier_id')
            ->leftJoin('tracking_updates', function($join) {
                $join->on('shipments.id', '=', 'tracking_updates.shipment_id')
                    ->whereRaw('tracking_updates.id = (SELECT MAX(id) FROM tracking_updates WHERE shipment_id = shipments.id)');
            })
            ->groupBy('carriers.id', 'carriers.name', 'carriers.code')
            ->get();
            
        return $carrierPerformance;
    }
    
    private function getCustomerSegments()
    {
        // Get customer segmentation data
        $customerSegments = Customer::select(
            DB::raw('CASE 
                WHEN COUNT(shipments.id) > 10 THEN "High Value"
                WHEN COUNT(shipments.id) > 5 THEN "Medium Value"
                ELSE "Low Value"
            END as segment'),
            DB::raw('COUNT(DISTINCT customers.id) as customer_count'),
            DB::raw('AVG(shipments.estimated_cost) as avg_order_value')
        )
        ->leftJoin('shipments', 'customers.id', '=', 'shipments.customer_id')
        ->groupBy('segment')
        ->get();
        
        return $customerSegments;
    }
    
    private function getInventoryStatus()
    {
        // Get inventory status data
        $inventoryStatus = Shipment::select(
            DB::raw('CASE 
                WHEN status = "In Transit" THEN "In Transit"
                WHEN status = "Out for Delivery" THEN "Out for Delivery"
                WHEN status = "Delivered" THEN "Delivered"
                ELSE "Other"
            END as status'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('status')
        ->get();
        
        return $inventoryStatus;
    }
} 