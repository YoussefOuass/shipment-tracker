<!-- Admin Navigation Links -->
@if (Auth::check() && Auth::user()->is_admin)
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>
        <x-nav-link :href="route('admin.analytics')" :active="request()->routeIs('admin.analytics')">
            {{ __('Analytics') }}
        </x-nav-link>
    </div>
@endif 

<div class="hidden sm:flex sm:items-center sm:ml-6">
    <div class="ml-3 relative">
        <div class="flex items-center">
            @if(auth()->user()->is_admin)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                    Admin
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                    User
                </span>
            @endif
            <x-dropdown align="right" width="48"> 