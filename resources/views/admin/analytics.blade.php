@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">📊 Admin Analytics Dashboard</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-lg font-semibold text-gray-700">Total Shipments</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $revenueData->sum('total_shipments') }}</p>
            <p class="text-sm text-gray-500">Last 30 days</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-lg font-semibold text-gray-700">Total Revenue</h3>
            <p class="text-2xl font-bold text-green-600">${{ number_format($revenueData->sum('total_revenue'), 2) }}</p>
            <p class="text-sm text-gray-500">Last 30 days</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-lg font-semibold text-gray-700">Active Carriers</h3>
            <p class="text-2xl font-bold text-purple-600">{{ $carrierPerformance->count() }}</p>
            <p class="text-sm text-gray-500">Currently in use</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-lg font-semibold text-gray-700">Total Customers</h3>
            <p class="text-2xl font-bold text-orange-600">{{ $customerSegments->sum('customer_count') }}</p>
            <p class="text-sm text-gray-500">Across all segments</p>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Revenue Tracking</h2>
        <div class="h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Carrier Performance -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Carrier Performance</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Carrier</th>
                        <th class="py-2">Code</th>
                        <th class="py-2">Total Shipments</th>
                        <th class="py-2">Delay Rate</th>
                        <th class="py-2">Performance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrierPerformance as $carrier)
                        <tr class="border-b">
                            <td class="py-2">{{ $carrier->name }}</td>
                            <td class="py-2">{{ $carrier->code }}</td>
                            <td class="py-2">{{ $carrier->total_shipments }}</td>
                            <td class="py-2">{{ number_format($carrier->delay_percentage, 1) }}%</td>
                            <td class="py-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-{{ $carrier->delay_percentage < 10 ? 'green' : ($carrier->delay_percentage < 20 ? 'yellow' : 'red') }}-500 h-2 rounded-full" 
                                         style="width: {{ 100 - min($carrier->delay_percentage, 100) }}%;">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Segmentation -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Customer Segmentation</h2>
            <div class="h-64">
                <canvas id="customerSegmentsChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Inventory Status</h2>
            <div class="h-64">
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueData->pluck('date')) !!},
                datasets: [
                    {
                        label: 'Revenue ($)',
                        data: {!! json_encode($revenueData->pluck('total_revenue')) !!},
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Shipments',
                        data: {!! json_encode($revenueData->pluck('total_shipments')) !!},
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        fill: true,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Shipments'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });

        // Customer Segments Chart
        const segmentsCtx = document.getElementById('customerSegmentsChart').getContext('2d');
        const segmentsChart = new Chart(segmentsCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($customerSegments->pluck('segment')) !!},
                datasets: [{
                    data: {!! json_encode($customerSegments->pluck('customer_count')) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Inventory Chart
        const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(inventoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($inventoryStatus->pluck('status')) !!},
                datasets: [{
                    data: {!! json_encode($inventoryStatus->pluck('count')) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(107, 114, 128, 0.7)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(107, 114, 128)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endsection 