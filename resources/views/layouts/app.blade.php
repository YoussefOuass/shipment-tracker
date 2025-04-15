<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shipment Tracker') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        a {
            text-decoration: none;
        }
        .nav-link {
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        .active-link {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('admin.home') }}" class="text-2xl font-bold text-gray-800">
                            📦 Shipment Tracker
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:flex sm:items-center space-x-4">
                        <a href="{{ route('track') }}" class="nav-link {{ request()->routeIs('track') ? 'active-link' : '' }}">
                            Track Shipment
                        </a>
                        @auth
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                                    Admin Panel
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Log in</a>
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 hover:text-gray-900">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6">
            @yield('content')
        </main>
    </div>
</body>
</html>