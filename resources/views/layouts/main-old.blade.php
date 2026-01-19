<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'DevAutoX' }}</title>
    
    <!-- Vite Assets (includes Tailwind CSS and PowerGrid) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
   
    @livewireStyles
    
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .overlay {
            transition: opacity 0.3s ease-in-out;
        }
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        .submenu.show {
            max-height: 500px;
        }
        .menu-item.active {
            transform: scale(0.95);
            opacity: 0.8;
        }
        .submenu-link:hover {
            transform: translateX(5px);
            transition: transform 0.2s ease;
        }
        
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-[#0b1933] shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-40 h-16">
        <div class="flex items-center justify-between h-full px-4">
            <!-- Left side - Logo and Menu Button -->
            <div class="flex items-center space-x-4">
                <!-- Menu Toggle Button -->
                <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-bars text-[#00969b] text-lg"></i>
                </button>
                
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-mountain text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-semibold text-white">DevAutox</span>
                </div>
                
                <!-- Breadcrumb -->
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600 ml-8">
                    <i class="fas fa-home text-teal-600"></i>
                    <span class="text-teal-600">Home</span>
                    <span class="text-teal-600">•</span>
                    <span class="text-teal-600">Welcome</span>
                </div>
            </div>
            
            <!-- Right side - User Info and Controls -->
            <div class="flex items-center space-x-4">
                <!-- Gas N Grub 2 -->
                <div class="hidden md:block text-sm text-[#00969b]">
                    {{ optional(auth()->user()->locations->first())->name ?? 'N/A' }}
                </div>

                
                <!-- Sunny Weather -->
                <div class="hidden md:flex items-center space-x-2 text-sm">
                    <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-sun text-yellow-600 text-xs"></i>
                    </div>
                    <span class="text-[#00969b]">Sunny</span>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-2">
                    <button class="p-2 rounded-lg hover:bg-gray-100 text-[#00969b]">
                        <i class="fas fa-question-circle"></i>
                    </button>
                    <button class="p-2 rounded-lg hover:bg-gray-100 text-[#00969b]">
                        <i class="fas fa-bullhorn"></i>
                    </button>
                    <button class="p-2 rounded-lg hover:bg-gray-100 text-[#00969b]">
                        <i class="fas fa-clock"></i>
                    </button>
                    <div class="relative">
                        <button id="userMenuButton" class="p-2 rounded-lg hover:bg-gray-100 text-[#00969b]">
                            <i class="fas fa-bars"></i>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-600">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 opacity-0 pointer-events-none overlay"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-16 h-full w-80 bg-white shadow-lg z-30 transform -translate-x-full sidebar-transition" style="width: 30rem;">
        <div class="p-4 h-full overflow-y-auto">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative">
                    <input id="searchInput" type="text" placeholder="Search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <!-- Search Results Submenu -->
                <div id="searchSubmenu" class="hidden mt-2">
                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-r-lg">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-search text-gray-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-gray-800">Search Results</h3>
                        </div>
                        <div id="searchResults" class="space-y-2">
                            <!-- Search results will be populated here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex space-x-1 mb-6 border-b border-gray-200">
                <button id="tab-all" class="px-4 py-2 text-sm font-medium text-teal-600 border-b-2 border-teal-600 bg-teal-50 rounded-t-lg">
                    ALL
                </button>
                <button id="tab-reports" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-t-lg hover:bg-gray-50">
                    REPORTS
                </button>
                <button id="tab-setup" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-t-lg hover:bg-gray-50">
                    SETUP
                </button>
            </div>

            <!-- Main Menu Items Grid -->
            <div class="grid grid-cols-3 gap-4 mb-6 main-menu-grid">
                <!-- Settings (for Setup tab) -->
                <div class="menu-item hidden flex flex-col items-center p-4 border-2 border-dashed border-purple-300 rounded-lg hover:bg-purple-50 cursor-pointer" data-menu="settings" data-scope="setup">
                    <div class="w-4 h-4 bg-purple-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-cog text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Settings</span>
                </div>
                <!-- Products -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-blue-300 rounded-lg hover:bg-blue-50 cursor-pointer" data-menu="products">
                    <div class="w-4 h-4 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-box text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Products</span>
                </div>

                <!-- Bank -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-blue-300 rounded-lg hover:bg-blue-50 cursor-pointer" data-menu="bank">
                    <div class="w-4 h-4 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-university text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Bank</span>
                </div>

                <!-- Other -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-yellow-300 rounded-lg hover:bg-yellow-50 cursor-pointer" data-menu="other">
                    <div class="w-4 h-4 bg-yellow-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-th text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Other</span>
                </div>

                <!-- Payroll -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-teal-300 rounded-lg hover:bg-teal-50 cursor-pointer" data-menu="payroll">
                    <div class="w-4 h-4 bg-teal-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-dollar-sign text-teal-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Payroll</span>
                </div>

                <!-- Send to POS -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-blue-300 rounded-lg hover:bg-blue-50 cursor-pointer" data-menu="sendtopos">
                    <div class="w-4 h-4 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-building text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Send POS</span>
                </div>

                <!-- Cartzie -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer" data-menu="cartzie">
                    <div class="w-4 h-4 bg-gray-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-chart-pie text-gray-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Cartzie</span>
                </div>

                <!-- Digital Display -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-blue-300 rounded-lg hover:bg-blue-50 cursor-pointer" data-menu="digitaldisplay">
                    <div class="w-4 h-4 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-desktop text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Digital Display</span>
                </div>

                <!-- Sunny AI -->
                <div class="menu-item flex flex-col items-center p-4 border-2 border-dashed border-yellow-300 rounded-lg hover:bg-yellow-50 cursor-pointer" data-menu="sunnyai">
                    <div class="w-4 h-4 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-sun text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Sunny AI</span>
                </div>
            </div>

            <!-- Sub-menus (templates, kept hidden) -->
            <div id="submenu-container" class="mb-6 hidden">
                <!-- Payroll Submenu -->
                <div id="submenu-payroll" class="submenu hidden">
                    <div class="bg-teal-50 border-l-4 border-teal-400 p-4 rounded-r-lg mb-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-dollar-sign text-teal-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-teal-800">Payroll</h3>
                        </div>
                        <div class="space-y-2">
                            <a href="/payroll/employees" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-users text-gray-500 mr-3 w-4"></i>
                                Employees
                            </a>
                            <a href="/payroll/create-pay-check" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-money-check text-gray-500 mr-3 w-4"></i>
                                Create Pay Check
                            </a>
                            <a href="/payroll/time-sheet" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-clock text-gray-500 mr-3 w-4"></i>
                                Time Sheet
                            </a>
                            <a href="/payroll/employee-history" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-history text-gray-500 mr-3 w-4"></i>
                                Employee History
                            </a>
                            <a href="/payroll/time-sheet-view" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-calendar-alt text-gray-500 mr-3 w-4"></i>
                                Time Sheet View
                            </a>
                            <a href="/payroll/taxes" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-receipt text-gray-500 mr-3 w-4"></i>
                                Payroll Taxes
                            </a>
                            <a href="/payroll/schedule" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-calendar text-gray-500 mr-3 w-4"></i>
                                Schedule
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Products Submenu -->
                <div id="submenu-products" class="submenu hidden">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-box text-blue-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-blue-800">Products</h3>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('products.pricebook.index') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-warehouse text-gray-500 mr-3 w-4"></i>
                                Price Book
                            </a>
                            <a href="{{ route('products.items') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-tags text-gray-500 mr-3 w-4"></i>
                                Items
                            </a>
                            <a href="/products/pricing" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-dollar-sign text-gray-500 mr-3 w-4"></i>
                                Pricing
                            </a>
                            <a href="/products/suppliers" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-truck text-gray-500 mr-3 w-4"></i>
                                Suppliers
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bank Submenu -->
                <div id="submenu-bank" class="submenu hidden">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-university text-blue-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-blue-800">Bank</h3>
                        </div>
                        <div class="space-y-2">
                            <a href="/bank/accounts" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-credit-card text-gray-500 mr-3 w-4"></i>
                                Accounts
                            </a>
                            <a href="/bank/transactions" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-exchange-alt text-gray-500 mr-3 w-4"></i>
                                Transactions
                            </a>
                            <a href="/bank/reconciliation" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-balance-scale text-gray-500 mr-3 w-4"></i>
                                Reconciliation
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Send to POS Submenu -->
                <div id="submenu-sendtopos" class="submenu hidden">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-building text-blue-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-blue-800">Send to POS</h3>
                        </div>
                        <div class="space-y-2">
                            <a href="/pos/sync-products" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-sync text-gray-500 mr-3 w-4"></i>
                                Sync Products
                            </a>
                            <a href="/pos/price-updates" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-tag text-gray-500 mr-3 w-4"></i>
                                Price Updates
                            </a>
                            <a href="/pos/status" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-wifi text-gray-500 mr-3 w-4"></i>
                                Connection Status
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Other Submenu -->
                <div id="submenu-other" class="submenu hidden">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg mb-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-th text-yellow-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-yellow-800">Other</h3>
                        </div>
                        <div class="space-y-2">
                            <a href="/other/settings" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-cog text-gray-500 mr-3 w-4"></i>
                                Settings
                            </a>
                            <a href="/other/backup" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-database text-gray-500 mr-3 w-4"></i>
                                Backup
                            </a>
                            <a href="/other/logs" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-file-alt text-gray-500 mr-3 w-4"></i>
                                System Logs
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Settings Submenu (for Setup tab) -->
                <div id="submenu-settings" class="submenu hidden">
                    <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded-r-lg mb-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-cog text-purple-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-purple-800">Settings</h3>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('payees') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-credit-card text-gray-500 mr-3 w-4"></i>
                                Payees
                            </a>
                            <a href="{{ route('departments') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-building text-gray-500 mr-3 w-4"></i>
                                Departments
                            </a>
                            <a href="{{ route('ages') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-birthday-cake text-gray-500 mr-3 w-4"></i>
                                Minimum Ages
                            </a>
                            <a href="{{ route('nacs-categories') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-tags text-gray-500 mr-3 w-4"></i>
                                NACS Categories
                            </a>
                            <a href="{{ route('product-categories') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-box-open text-gray-500 mr-3 w-4"></i>
                                Product Categories
                            </a>
                            <a href="{{ route('sale-type') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-shopping-cart text-gray-500 mr-3 w-4"></i>
                                Sale Type
                            </a>
                            <a href="{{ route('sizes') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-ruler-combined text-gray-500 mr-3 w-4"></i>
                                Sizes
                            </a>
                            <a href="{{ route('measures') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-balance-scale text-gray-500 mr-3 w-4"></i>
                                Units of Measure
                            </a>
                            <a href="{{ route('terms') }}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-file-contract text-gray-500 mr-3 w-4"></i>
                                Terms
                            </a>
                            <!-- Locations menu -->
                            <a href="{{ route('locations') }}" 
                            class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-map-marker-alt text-gray-500 mr-3 w-4"></i>
                                Locations
                            </a>

                            <!-- Attach user to location -->
                            <a href="{{ route('attach-locations') }}" 
                            class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                                <i class="fas fa-user-plus text-gray-500 mr-3 w-4"></i>
                                Attach Location
                            </a>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent View Section -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="flex items-center text-sm font-medium text-teal-600 mb-4">
                    <i class="fas fa-clock mr-2"></i>
                    Recent View
                </h3>
                
                <div class="space-y-2">
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-cash-register text-gray-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Cashier</span>
                    </div>
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-users text-gray-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Payees</span>
                    </div>
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-cube text-gray-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Items</span>
                    </div>
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-tag text-gray-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Price Book</span>
                    </div>
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-shopping-cart text-gray-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Purchases</span>
                    </div>
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-clipboard-list text-gray-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Item Logs</span>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="pt-16 transition-all duration-300" id="mainContent">
        <div class="p-6">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');
            const menuItems = document.querySelectorAll('.menu-item');
            const submenus = document.querySelectorAll('.submenu');
            const userMenuButton = document.getElementById('userMenuButton');
            const userDropdown = document.getElementById('userDropdown');

            // User dropdown toggle
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
            const mainMenuGrid = document.querySelector('.main-menu-grid');
            const tabAll = document.getElementById('tab-all');
            const tabReports = document.getElementById('tab-reports');
            const tabSetup = document.getElementById('tab-setup');
            const searchInput = document.getElementById('searchInput');
            const searchSubmenu = document.getElementById('searchSubmenu');
            const searchResults = document.getElementById('searchResults');
            
            let sidebarOpen = false;
            let activeMenu = null;
            let activeSubmenuSlot = null;
            let searchTimeout = null;
            let searchIndex = [];

            function buildSearchIndex() {
                const index = [];
                document.querySelectorAll('#submenu-container > .submenu').forEach(section => {
                    const titleEl = section.querySelector('h3');
                    const sectionTitle = titleEl ? titleEl.textContent.trim() : '';
                    section.querySelectorAll('a.submenu-link').forEach(link => {
                        const itemTitle = link.textContent.trim();
                        const iconEl = link.querySelector('i');
                        const iconClass = iconEl ? iconEl.className : 'fas fa-circle';
                        const href = link.getAttribute('href') || '#';
                        index.push({ title: itemTitle, icon: iconClass, url: href, category: sectionTitle });
                    });
                });
                // Also include main tiles for completeness
                document.querySelectorAll('.main-menu-grid .menu-item').forEach(tile => {
                    const titleEl = tile.querySelector('span');
                    const itemTitle = titleEl ? titleEl.textContent.trim() : '';
                    const iconEl = tile.querySelector('i');
                    const iconClass = iconEl ? iconEl.className : 'fas fa-square';
                    const menuType = tile.getAttribute('data-menu');
                    if (itemTitle && menuType) {
                        index.push({ title: itemTitle, icon: iconClass, url: `#${menuType}`, category: 'Main Menu' });
                    }
                });
                searchIndex = index;
            }

            function toggleSidebar() {
                sidebarOpen = !sidebarOpen;
                
                if (sidebarOpen) {
                    // Open sidebar
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
                    sidebarOverlay.classList.add('opacity-100', 'pointer-events-auto');
                    
                    // Add margin to main content on larger screens
                    if (window.innerWidth >= 1024) {
                        mainContent.style.marginLeft = '320px';
                    }
                } else {
                    // Close sidebar
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.remove('opacity-100', 'pointer-events-auto');
                    sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
                    mainContent.style.marginLeft = '0';
                    
                    // Hide all submenus when sidebar closes
                    hideAllSubmenus();
                }
            }

            function hideAllSubmenus() {
                // hide templates (kept hidden container)
                submenus.forEach(submenu => {
                    submenu.classList.remove('show');
                    submenu.classList.add('hidden');
                });
                // remove dynamic slot if present
                if (activeSubmenuSlot && activeSubmenuSlot.parentNode) {
                    activeSubmenuSlot.parentNode.removeChild(activeSubmenuSlot);
                }
                activeSubmenuSlot = null;
                // remove active style
                menuItems.forEach(item => {
                    item.classList.remove('active');
                });
                activeMenu = null;
            }

            function showSubmenu(menuType) {
                // Hide all submenus first
                hideAllSubmenus();
                
                // Show the selected submenu
                const submenu = document.getElementById(`submenu-${menuType}`);
                if (submenu) {
                    // Determine where to insert: directly below the row of the clicked item
                    const menuItem = document.querySelector(`[data-menu="${menuType}"]`);
                    if (!menuItem) return;

                    // Create a full-width grid slot
                    activeSubmenuSlot = document.createElement('div');
                    activeSubmenuSlot.className = 'col-span-3';

                    // Copy submenu content into the slot
                    activeSubmenuSlot.innerHTML = submenu.innerHTML;

                    // compute insertion index after the row containing the clicked item
                    const itemsArray = Array.from(mainMenuGrid.querySelectorAll('.menu-item'));
                    const index = itemsArray.indexOf(menuItem);
                    const cols = 3; // grid-cols-3
                    const rowEndIndex = Math.min(itemsArray.length - 1, Math.floor(index / cols) * cols + (cols - 1));
                    const insertAfterEl = itemsArray[rowEndIndex];
                    if (insertAfterEl && insertAfterEl.nextSibling) {
                        mainMenuGrid.insertBefore(activeSubmenuSlot, insertAfterEl.nextSibling);
                    } else {
                        mainMenuGrid.appendChild(activeSubmenuSlot);
                    }

                    // small animation toggle on copied block
                    setTimeout(() => {
                        const firstChild = activeSubmenuSlot.firstElementChild;
                        if (firstChild) {
                            firstChild.classList.add('animate-[fadeIn_0.2s_ease]');
                        }
                    }, 10);

                    // Mark the menu item as active
                    menuItem.classList.add('active');
                    activeMenu = menuType;
                }
            }

            // Add click handlers for menu items
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    const menuType = this.getAttribute('data-menu');
                    
                    if (activeMenu === menuType) {
                        // If clicking on the already active menu, hide it
                        hideAllSubmenus();
                    } else {
                        // Show the submenu for this item
                        showSubmenu(menuType);
                    }
                });
            });

            // Tabs logic
            function activateTab(target) {
                // Reset tab button styles
                [tabAll, tabReports, tabSetup].forEach(btn => {
                    if (!btn) return;
                    btn.classList.remove('text-teal-600','border-b-2','border-teal-600','bg-teal-50');
                    btn.classList.add('text-gray-600');
                });

                // Reset: hide setup-scoped tiles by default for ALL/REPORTS views
                document.querySelectorAll('.main-menu-grid .menu-item').forEach(el => {
                    if (el.getAttribute('data-scope') === 'setup') {
                        el.classList.add('hidden');
                    } else {
                        el.classList.remove('hidden');
                    }
                });

                if (target === 'all') {
                    tabAll.classList.add('text-teal-600','border-b-2','border-teal-600','bg-teal-50');
                    hideAllSubmenus();
                    return;
                }

                if (target === 'setup') {
                    tabSetup.classList.add('text-teal-600','border-b-2','border-teal-600','bg-teal-50');
                    // Hide non-setup tiles; show only tiles with data-scope="setup"
                    document.querySelectorAll('.main-menu-grid .menu-item').forEach(el => {
                        if (el.getAttribute('data-scope') === 'setup') {
                            el.classList.remove('hidden');
                        } else {
                            el.classList.add('hidden');
                        }
                    });
                    // Keep submenu collapsed by default on SETUP
                    hideAllSubmenus();
                    return;
                }

                if (target === 'reports') {
                    tabReports.classList.add('text-teal-600','border-b-2','border-teal-600','bg-teal-50');
                    // Placeholder: filter to report-related tiles when available
                    hideAllSubmenus();
                    return;
                }
            }

            if (tabAll) tabAll.addEventListener('click', () => activateTab('all'));
            if (tabReports) tabReports.addEventListener('click', () => activateTab('reports'));
            if (tabSetup) tabSetup.addEventListener('click', () => activateTab('setup'));

            // Search functionality
            function performSearch(query) {
                if (!query.trim()) {
                    searchSubmenu.classList.add('hidden');
                    return;
                }

                const filteredResults = searchIndex.filter(item => 
                    item.title.toLowerCase().includes(query.toLowerCase()) ||
                    item.category.toLowerCase().includes(query.toLowerCase())
                );

                if (filteredResults.length > 0) {
                    searchResults.innerHTML = filteredResults.map(result => `
                        <a href="${result.url}" class="submenu-link flex items-center p-2 text-sm text-gray-700 hover:bg-white hover:shadow-sm rounded cursor-pointer">
                            <i class="${result.icon} text-gray-500 mr-3 w-4"></i>
                            <div>
                                <div class="font-medium">${result.title}</div>
                                <div class="text-xs text-gray-500">${result.category}</div>
                            </div>
                        </a>
                    `).join('');
                    searchSubmenu.classList.remove('hidden');
                } else {
                    searchResults.innerHTML = '<div class="text-sm text-gray-500 p-2">No results found</div>';
                    searchSubmenu.classList.remove('hidden');
                }
            }

            if (searchInput) {
                // Build index once on load
                buildSearchIndex();

                searchInput.addEventListener('input', function() {
                    const query = this.value;
                    
                    // Clear previous timeout
                    if (searchTimeout) {
                        clearTimeout(searchTimeout);
                    }
                    
                    // Debounce search
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                });

                // Hide search results when input loses focus (with delay)
                searchInput.addEventListener('blur', function() {
                    setTimeout(() => {
                        if (!searchSubmenu.contains(document.activeElement)) {
                            searchSubmenu.classList.add('hidden');
                        }
                    }, 200);
                });
            }

            sidebarToggle.addEventListener('click', toggleSidebar);
            
            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', toggleSidebar);

            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebarOpen) {
                    toggleSidebar();
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth < 1024 && sidebarOpen) {
                    mainContent.style.marginLeft = '0';
                } else if (window.innerWidth >= 1024 && sidebarOpen) {
                    mainContent.style.marginLeft = '320px';
                }
            });
        });
    </script>
    
    @livewireScripts
   
</body>
</html>