@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Notification Preferences</h1>
                <a href="{{ route('shipments.tracking', $shipment) }}" class="text-blue-500 hover:text-blue-600">
                    Back to Tracking
                </a>
            </div>

            <!-- Shipment Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Tracking Number</p>
                        <p class="font-medium">{{ $shipment->tracking_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium">{{ $shipment->status }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Carrier</p>
                        <p class="font-medium">{{ $shipment->carrier->name }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('shipments.notification-preferences', $shipment) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Email Notifications -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Email Notifications</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">Status Updates</p>
                                <p class="text-sm text-gray-600">Receive email notifications when shipment status changes</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_status_updates" class="sr-only peer" 
                                    {{ $preferences->email_status_updates ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                                    after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">Delivery Updates</p>
                                <p class="text-sm text-gray-600">Receive email notifications about delivery progress</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_delivery_updates" class="sr-only peer"
                                    {{ $preferences->email_delivery_updates ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                                    after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- SMS Notifications -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">SMS Notifications</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">Status Updates</p>
                                <p class="text-sm text-gray-600">Receive SMS notifications when shipment status changes</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="sms_status_updates" class="sr-only peer"
                                    {{ $preferences->sms_status_updates ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                                    after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">Delivery Updates</p>
                                <p class="text-sm text-gray-600">Receive SMS notifications about delivery progress</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="sms_delivery_updates" class="sr-only peer"
                                    {{ $preferences->sms_delivery_updates ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                                    after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Save Preferences
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 