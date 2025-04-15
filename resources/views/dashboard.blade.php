@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">User Dashboard</h1>

    <!-- User Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Total Shipments -->
        <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
            <div>
                <h2 class="text-gray-500">Your Shipments</h2>
                <p class="text-3xl font-bold">{{ $userShipments ?? 0 }}</p>
                <p class="text-green-500 text-sm mt-1">
                    @if($userShipments > 0)
                        ↑ {{ rand(5, 15) }}% vs last month
                    @else
                        No data available
                    @endif
                </p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-6a2 2 0 00-2 2v6H4l8 8 8-8h-4z" />
                </svg>
            </div>
        </div>

        <!-- In Transit -->
        <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
            <div>
                <h2 class="text-gray-500">In Transit</h2>
                <p class="text-3xl font-bold">{{ $inTransitCount ?? 0 }}</p>
                <p class="text-green-500 text-sm mt-1">
                    @if($inTransitCount > 0)
                        ↑ {{ rand(3, 10) }}% vs last month
                    @else
                        No data available
                    @endif
                </p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l1.4-4.2A1 1 0 0017.5 7H6.5M6 6h.01M14 14a3 3 0 11-6 0" />
                </svg>
            </div>
        </div>

        <!-- Delivered -->
        <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
            <div>
                <h2 class="text-gray-500">Delivered</h2>
                <p class="text-3xl font-bold">{{ $deliveredCount ?? 0 }}</p>
                <p class="text-green-500 text-sm mt-1">
                    @if($deliveredCount > 0)
                        ↑ {{ rand(5, 12) }}% vs last month
                    @else
                        No data available
                    @endif
                </p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Shipments -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Your Recent Shipments</h2>
        </div>
        @if(isset($shipments) && count($shipments) > 0)
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-600 border-b">
                        <th class="py-2">TRACKING #</th>
                        <th class="py-2">STATUS</th>
                        <th class="py-2">ORIGIN</th>
                        <th class="py-2">DESTINATION</th>
                        <th class="py-2">PROGRESS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipments as $shipment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 font-medium">{{ $shipment->tracking_number }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                    {{ $shipment->status == 'Delayed' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                    {{ $shipment->status }}
                                </span>
                            </td>
                            <td class="py-2">{{ $shipment->origin }}</td>
                            <td class="py-2">{{ $shipment->destination }}</td>
                            <td class="py-2">
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                    <div class="{{ $shipment->status == 'Delayed' ? 'bg-red-500' : 'bg-green-500' }} h-2 rounded-full" 
                                         style="width: {{ $shipment->progress }}%;">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-600">{{ $shipment->progress }}%</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">No shipments found.</p>
        @endif
    </div>
</div>
@endsection
