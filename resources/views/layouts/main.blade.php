<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'DevAutoX' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
   <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>
<body class="bg-gray-100 overflow-hidden">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 h-14 z-50">
        <div class="h-full px-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2.5">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Total Store" class="h-12 w-auto" style="width: 200px; height: 100px; object-fit: contain;">
                </a>
            </div>
            
            <!-- Right Side -->
            <div class="flex items-center gap-4">
                <!-- Location -->
                <div class="hidden lg:flex items-center gap-2 text-xs text-gray-600">
                    <i class="fas fa-map-marker-alt text-green-500"></i>
                    <span>{{ optional(auth()->user()->locations->first())->name ?? 'N/A' }}</span>
                </div>

                <!-- Weather -->
                <div class="hidden lg:flex items-center gap-2">
                    <div class="w-7 h-7 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-sun text-white text-xs"></i>
                    </div>
                    <span class="text-xs text-gray-600">Sunny</span>
                </div>
                
                <!-- Help -->
                <button class="w-8 h-8 rounded-full bg-gray-100 hover:bg-green-500/10 flex items-center justify-center transition-colors">
                    <i class="fas fa-question text-gray-600 hover:text-green-500 text-xs"></i>
                </button>

                <!-- Notifications -->
                <button class="w-8 h-8 rounded-full bg-gray-100 hover:bg-red-500/10 flex items-center justify-center transition-colors">
                    <i class="fas fa-bell text-gray-600 hover:text-red-500 text-xs"></i>
                </button>
                
                <!-- User Menu -->
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-500 text-[10px]"></i>
                    </button>
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1.5 z-50">
                        <div class="px-3 py-2 border-b border-gray-100">
                            <p class="text-[10px] text-gray-500">Signed in as</p>
                            <p class="text-xs font-semibold text-gray-900 mt-0.5">{{ auth()->user()->name }}</p>
                        </div>
                        <a href="#" class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                            <i class="fas fa-user w-4 mr-2 text-gray-400 text-[10px]"></i>
                            Profile
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                            <i class="fas fa-cog w-4 mr-2 text-gray-400 text-[10px]"></i>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1 pt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-3 py-2 text-xs text-red-500 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-4 mr-2 text-[10px]"></i>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-14 h-[calc(100vh-3.5rem)] w-60 bg-gradient-to-b from-emerald-900/80 to-emerald-950/90 overflow-y-auto z-40 scrollbar-thin scrollbar-thumb-green-500/40 scrollbar-track-emerald-800/50">
        <div class="py-3 px-3">
            <!-- Search Bar -->
            <div class="mb-3">
                <div class="relative">
                    <input id="sidebarSearch" type="text" placeholder="Search..." class="w-full pl-8 pr-3 py-1.5 bg-white rounded-md text-xs text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-green-400">
                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]"></i>
                </div>
            </div>

            <!-- Search Results -->
            <div id="searchResults" class="hidden mb-3">
                <div class="bg-white/5 rounded-md p-2">
                    <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-2 px-2">Search Results</div>
                    <div id="searchResultsList" class="space-y-0.5">
                        <!-- Results will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-0.5">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group {{ Route::is('dashboard') ? 'text-white bg-green-500/20' : '' }}">
                    <i class="fas fa-home w-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Products -->
                <div class="menu-group">
                    <button class="menu-toggle w-full flex items-center justify-between px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right w-3 mr-1.5 text-gray-500 text-[10px] transition-transform duration-200" style="transform: rotate(90deg);"></i>
                            <i class="fas fa-box w-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                            <span>Products</span>
                        </div>
                    </button>
                    <div class="submenu ml-7 mt-0.5 space-y-0.5">
                        <a href="{{ route('products.pricebook.index') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-white hover:bg-green-500/10 transition-colors {{ Route::is('products.pricebook.index') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-tag w-3.5 mr-2 text-[10px]"></i>
                            <span>Price Book</span>
                        </a>
                        <a href="{{ route('products.items') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('products.items') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-cube w-3.5 mr-2 text-[10px]"></i>
                            <span>Items</span>
                        </a>
                        {{-- <a href="/products/pricing" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-dollar-sign w-3.5 mr-2 text-[10px]"></i>
                            <span>Pricing</span>
                        </a>
                        <a href="/products/suppliers" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-truck w-3.5 mr-2 text-[10px]"></i>
                            <span>Suppliers</span>
                        </a> --}}
                    </div>
                </div>

                <!-- Bank -->
                {{-- <div class="menu-group">
                    <button class="menu-toggle w-full flex items-center justify-between px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right w-3 mr-1.5 text-gray-500 text-[10px] transition-transform duration-200"></i>
                            <i class="fas fa-university w-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                            <span>Bank</span>
                        </div>
                    </button>
                    <div class="submenu hidden ml-7 mt-0.5 space-y-0.5">
                        <a href="/bank/accounts" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-credit-card w-3.5 mr-2 text-[10px]"></i>
                            <span>Accounts</span>
                        </a>
                        <a href="/bank/transactions" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-exchange-alt w-3.5 mr-2 text-[10px]"></i>
                            <span>Transactions</span>
                        </a>
                        <a href="/bank/reconciliation" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-balance-scale w-3.5 mr-2 text-[10px]"></i>
                            <span>Reconciliation</span>
                        </a>
                    </div>
                </div> --}}

                <!-- Payroll -->
                {{-- <div class="menu-group">
                    <button class="menu-toggle w-full flex items-center justify-between px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right w-3 mr-1.5 text-gray-500 text-[10px] transition-transform duration-200"></i>
                            <i class="fas fa-dollar-sign w-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                            <span>Payroll</span>
                        </div>
                    </button>
                    <div class="submenu hidden ml-7 mt-0.5 space-y-0.5">
                        <a href="/payroll/employees" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-users w-3.5 mr-2 text-[10px]"></i>
                            <span>Employees</span>
                        </a>
                        <a href="/payroll/create-pay-check" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-money-check w-3.5 mr-2 text-[10px]"></i>
                            <span>Create Pay Check</span>
                        </a>
                        <a href="/payroll/time-sheet" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-clock w-3.5 mr-2 text-[10px]"></i>
                            <span>Time Sheet</span>
                        </a>
                        <a href="/payroll/employee-history" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-history w-3.5 mr-2 text-[10px]"></i>
                            <span>Employee History</span>
                        </a>
                        <a href="/payroll/time-sheet-view" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-calendar-alt w-3.5 mr-2 text-[10px]"></i>
                            <span>Time Sheet View</span>
                        </a>
                        <a href="/payroll/taxes" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-receipt w-3.5 mr-2 text-[10px]"></i>
                            <span>Payroll Taxes</span>
                        </a>
                        <a href="/payroll/schedule" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-calendar w-3.5 mr-2 text-[10px]"></i>
                            <span>Schedule</span>
                        </a>
                    </div>
                </div> --}}

                <!-- Send to POS -->
                {{-- <div class="menu-group">
                    <button class="menu-toggle w-full flex items-center justify-between px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right w-3 mr-1.5 text-gray-500 text-[10px] transition-transform duration-200"></i>
                            <i class="fas fa-building w-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                            <span>Send to POS</span>
                        </div>
                    </button>
                    <div class="submenu hidden ml-7 mt-0.5 space-y-0.5">
                        <a href="/pos/sync-products" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-sync w-3.5 mr-2 text-[10px]"></i>
                            <span>Sync Products</span>
                        </a>
                        <a href="/pos/price-updates" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-tag w-3.5 mr-2 text-[10px]"></i>
                            <span>Price Updates</span>
                        </a>
                        <a href="/pos/status" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors">
                            <i class="fas fa-wifi w-3.5 mr-2 text-[10px]"></i>
                            <span>Connection Status</span>
                        </a>
                    </div>
                </div> --}}

                <!-- Settings -->
                <div class="menu-group">
                    <button class="menu-toggle w-full flex items-center justify-between px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right w-3 mr-1.5 text-gray-500 text-[10px] transition-transform duration-200" style="transform: rotate(90deg);"></i>
                            <i class="fas fa-cog w-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                            <span>Settings</span>
                        </div>
                    </button>
                    <div class="submenu ml-7 mt-0.5 space-y-0.5">
                        <a href="{{ route('payees') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('payees') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-credit-card w-3.5 mr-2 text-[10px]"></i>
                            <span>Payees</span>
                        </a>
                        <a href="{{ route('departments') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('departments') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-building w-3.5 mr-2 text-[10px]"></i>
                            <span>Departments</span>
                        </a>
                        <a href="{{ route('ages') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('ages') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-birthday-cake w-3.5 mr-2 text-[10px]"></i>
                            <span>Minimum Ages</span>
                        </a>
                        <a href="{{ route('nacs-categories') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('nacs-categories') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-tags w-3.5 mr-2 text-[10px]"></i>
                            <span>NACS Categories</span>
                        </a>
                        <a href="{{ route('product-categories') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('product-categories') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-box-open w-3.5 mr-2 text-[10px]"></i>
                            <span>Product Categories</span>
                        </a>
                        <a href="{{ route('sale-type') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('sale-type') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-shopping-cart w-3.5 mr-2 text-[10px]"></i>
                            <span>Sale Type</span>
                        </a>
                        <a href="{{ route('sizes') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('sizes') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-ruler-combined w-3.5 mr-2 text-[10px]"></i>
                            <span>Sizes</span>
                        </a>
                        <a href="{{ route('measures') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('measures') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-balance-scale w-3.5 mr-2 text-[10px]"></i>
                            <span>Units of Measure</span>
                        </a>
                        <a href="{{ route('terms') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('terms') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-file-contract w-3.5 mr-2 text-[10px]"></i>
                            <span>Terms</span>
                        </a>
                        <a href="{{ route('locations') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('locations') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-map-marker-alt w-3.5 mr-2 text-[10px]"></i>
                            <span>Locations</span>
                        </a>
                        <a href="{{ route('attach-locations') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('attach-locations') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-user-plus w-3.5 mr-2 text-[10px]"></i>
                            <span>Attach Location</span>
                        </a>
                        <a href="{{ route('users') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('users') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-users w-3.5 mr-2 text-[10px]"></i>
                            <span>Users</span>
                        </a>
                        @can('manage permissions')
                        <a href="{{ route('permissions') }}" class="flex items-center px-2.5 py-1.5 text-gray-400 text-xs rounded-md hover:text-gray-300 hover:bg-white/5 transition-colors {{ Route::is('permissions') ? 'text-white bg-green-500/20' : '' }}">
                            <i class="fas fa-shield-alt w-3.5 mr-2 text-[10px]"></i>
                            <span>Permissions</span>
                        </a>
                        @endcan
                    </div>
                </div>

                <!-- Cartzie -->
                {{-- <a href="#" class="flex items-center px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                    <i class="fas fa-chart-pie w-4 ml-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                    <span>Cartzie</span>
                </a> --}}

                <!-- Digital Display -->
                {{-- <a href="#" class="flex items-center px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-red-500/10 hover:text-white transition-colors group">
                    <i class="fas fa-desktop w-4 ml-4 mr-2.5 text-gray-400 group-hover:text-red-400"></i>
                    <span>Digital Display</span>
                </a> --}}

                <!-- Sunny AI -->
                {{-- <a href="#" class="flex items-center px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                    <i class="fas fa-sun w-4 ml-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                    <span>Sunny AI</span>
                </a> --}}
            </nav>

            <!-- Pages Section -->
            {{-- <div class="mt-4 pt-3 border-t border-gray-600">
                <div class="px-2.5 mb-2">
                    <h3 class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Pages</h3>
                </div>
                <a href="#" class="flex items-center px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                    <i class="fas fa-file w-4 ml-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                    <span>Starter</span>
                </a>
                <div class="menu-group">
                    <button class="menu-toggle w-full flex items-center justify-between px-2.5 py-2 text-gray-300 text-xs rounded-md hover:bg-green-500/10 hover:text-white transition-colors group">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right w-3 mr-1.5 text-gray-500 text-[10px] transition-transform duration-200"></i>
                            <i class="fas fa-question-circle w-4 mr-2.5 text-gray-400 group-hover:text-green-400"></i>
                            <span>FAQ</span>
                        </div>
                    </button>
                </div>
            </div> --}}

            <!-- Collapsed View -->
            {{-- <div class="mt-4 pt-3 border-t border-gray-600">
                <button class="flex items-center px-2.5 py-2 text-gray-400 text-xs rounded-md hover:bg-white/5 hover:text-gray-300 transition-colors w-full group">
                    <i class="fas fa-arrow-left w-4 mr-2.5 text-[10px]"></i>
                    <span>Collapsed View</span>
                </button>
            </div> --}}
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-60 pt-14 h-screen overflow-y-auto">
        <div class="p-4">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.getElementById('userMenuButton');
            const userDropdown = document.getElementById('userDropdown');
            const menuToggles = document.querySelectorAll('.menu-toggle');
            const sidebarSearch = document.getElementById('sidebarSearch');
            const searchResults = document.getElementById('searchResults');
            const searchResultsList = document.getElementById('searchResultsList');
            const navigationMenu = document.querySelector('aside nav');
            let searchIndex = [];

            // Build search index
            function buildSearchIndex() {
                const index = [];
                
                // Get all menu links
                document.querySelectorAll('aside nav a[href]').forEach(link => {
                    const text = link.textContent.trim();
                    const href = link.getAttribute('href');
                    const icon = link.querySelector('i');
                    const iconClass = icon ? icon.className : 'fas fa-circle';
                    
                    // Determine category
                    let category = 'Main Menu';
                    const parentMenu = link.closest('.submenu');
                    if (parentMenu) {
                        const parentToggle = parentMenu.previousElementSibling;
                        if (parentToggle) {
                            category = parentToggle.querySelector('span').textContent.trim();
                        }
                    }
                    
                    index.push({
                        title: text,
                        href: href,
                        icon: iconClass,
                        category: category
                    });
                });
                
                return index;
            }

            // Search functionality
            function performSearch(query) {
                if (!query.trim()) {
                    searchResults.classList.add('hidden');
                    navigationMenu.classList.remove('hidden');
                    return;
                }

                const filteredResults = searchIndex.filter(item => 
                    item.title.toLowerCase().includes(query.toLowerCase()) ||
                    item.category.toLowerCase().includes(query.toLowerCase())
                );

                if (filteredResults.length > 0) {
                    searchResultsList.innerHTML = filteredResults.map(result => `
                        <a href="${result.href}" class="flex items-center px-2.5 py-1.5 text-gray-300 text-xs rounded-md hover:text-white hover:bg-green-500/10 transition-colors">
                            <i class="${result.icon} w-3.5 mr-2 text-[10px] text-gray-400"></i>
                            <div class="flex-1">
                                <div class="font-medium">${result.title}</div>
                                <div class="text-[10px] text-gray-500">${result.category}</div>
                            </div>
                        </a>
                    `).join('');
                    searchResults.classList.remove('hidden');
                    navigationMenu.classList.add('hidden');
                } else {
                    searchResultsList.innerHTML = '<div class="text-xs text-gray-500 px-2.5 py-2">No results found</div>';
                    searchResults.classList.remove('hidden');
                    navigationMenu.classList.add('hidden');
                }
            }

            // Initialize search
            if (sidebarSearch) {
                searchIndex = buildSearchIndex();
                
                let searchTimeout;
                sidebarSearch.addEventListener('input', function() {
                    const query = this.value;
                    
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                });

                // Clear search on escape
                sidebarSearch.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        this.value = '';
                        searchResults.classList.add('hidden');
                        navigationMenu.classList.remove('hidden');
                    }
                });
            }

            // User dropdown
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            // Submenu toggles (disabled for Settings and Products - they stay open)
            menuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const menuGroup = this.closest('.menu-group');
                    const submenu = menuGroup.querySelector('.submenu');
                    const chevron = this.querySelector('.fa-chevron-right');
                    
                    // Check if this is Settings or Products - if so, don't toggle
                    const menuText = this.querySelector('span').textContent.trim();
                    if (menuText === 'Settings' || menuText === 'Products') {
                        return; // Do nothing - these menus stay open
                    }
                    
                    // Toggle submenu
                    submenu.classList.toggle('hidden');
                    
                    // Rotate chevron
                    if (!submenu.classList.contains('hidden')) {
                        chevron.style.transform = 'rotate(90deg)';
                    } else {
                        chevron.style.transform = 'rotate(0deg)';
                    }
                });
            });

            // Mark active link (Route::is() is handled server-side, but we keep this as fallback)
            const currentPath = window.location.pathname;
            document.querySelectorAll('aside a[href]').forEach(link => {
                const href = link.getAttribute('href');
                // Check if already has active class from server-side Route::is()
                if (link.classList.contains('bg-green-500/20')) {
                    // Already active from server-side, ensure text is white
                    link.classList.remove('text-gray-300', 'text-gray-400');
                    link.classList.add('text-white');
                } else {
                    // Remove active state for links that shouldn't be active
                    link.classList.remove('text-white', 'bg-green-500/20');
                    // Only apply active state if path exactly matches
                    if (href && currentPath === href) {
                        link.classList.remove('text-gray-300', 'text-gray-400');
                        link.classList.add('text-white', 'bg-green-500/20');
                        
                        // Expand parent if in submenu (but Settings and Products are always open)
                        const parentSubmenu = link.closest('.submenu');
                        if (parentSubmenu) {
                            parentSubmenu.classList.remove('hidden');
                            const parentToggle = parentSubmenu.previousElementSibling;
                            if (parentToggle) {
                                const chevron = parentToggle.querySelector('.fa-chevron-right');
                                if (chevron) chevron.style.transform = 'rotate(90deg)';
                            }
                        }
                    }
                }
            });
        });
    </script>
    
    @livewireScripts
</body>
</html>