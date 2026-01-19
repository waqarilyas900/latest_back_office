<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wowdash - Tailwind CSS Admin Dashboard HTML Template</title>
  <link rel="icon" type="image/png" href="assets/images/favicon.png" sizes="16x16">
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="assets/css/remixicon.css">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="assets/css/lib/apexcharts.css">
  <!-- Data Table css -->
  <link rel="stylesheet" href="assets/css/lib/dataTables.min.css">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="assets/css/lib/editor-katex.min.css">
  <link rel="stylesheet" href="assets/css/lib/editor.atom-one-dark.min.css">
  <link rel="stylesheet" href="assets/css/lib/editor.quill.snow.css">
  <!-- Date picker css -->
  <link rel="stylesheet" href="assets/css/lib/flatpickr.min.css">
  <!-- Calendar css -->
  <link rel="stylesheet" href="assets/css/lib/full-calendar.css">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="assets/css/lib/jquery-jvectormap-2.0.5.css">
  <!-- Popup css -->
  <link rel="stylesheet" href="assets/css/lib/magnific-popup.css">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="assets/css/lib/slick.css">
  <!-- prism css -->
  <link rel="stylesheet" href="assets/css/lib/prism.css">
  <!-- file upload css -->
  <link rel="stylesheet" href="assets/css/lib/file-upload.css">
  
  <link rel="stylesheet" href="assets/css/lib/audioplayer.css">
  <!-- main css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">
<aside class="sidebar">
  <button type="button" class="sidebar-close-btn !mt-4">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="index.html" class="sidebar-logo">
      <img src="assets/images/logo.png" alt="site logo" class="light-logo">
      <img src="assets/images/logo-light.png" alt="site logo" class="dark-logo">
      <img src="assets/images/logo-icon.png" alt="site logo" class="logo-icon">
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Dashboard</span>
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="index.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> AI</a>
          </li>
          <li>
            <a href="index-2.html"><i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> CRM</a>
          </li>
          <li>
            <a href="index-3.html"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> eCommerce</a>
          </li>
          <li>
            <a href="index-4.html"><i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Cryptocurrency</a>
          </li>
          <li>
            <a href="index-5.html"><i class="ri-circle-fill circle-icon text-success-600 w-auto"></i> Investment</a>
          </li>
          <li>
            <a href="index-6.html"><i class="ri-circle-fill circle-icon text-purple-600 w-auto"></i> LMS / Learning System</a>
          </li>
          <li>
            <a href="index-7.html"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> NFT & Gaming</a>
          </li>
          <li>
            <a href="index-8.html"><i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Medical</a>
          </li>
          <li>
            <a href="index-9.html"><i class="ri-circle-fill circle-icon text-purple-600 w-auto"></i> Analytics</a>
          </li>
        </ul>
      </li>
     
      {{-- ================= Settings ================= --}}
      <li class="dropdown open dropdown-open">
          <a href="javascript:void(0)">
              <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
              <span>Settings</span> 
          </a>
          <ul class="sidebar-submenu space-y-1">
              <li>
                  <a href="{{ route('payees') }}" class="flex items-center gap-2 {{ Route::is('payees') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-user-3-line text-primary-600"></i></span>
                      <span>Payees</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('departments') }}" class="flex items-center gap-2 {{ Route::is('departments') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-building-line text-warning-600"></i></span>
                      <span>Departments</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('ages') }}" class="flex items-center gap-2 {{ Route::is('ages') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-cake-2-line text-info-600"></i></span>
                      <span>Min Ages</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('nacs-categories') }}" class="flex items-center gap-2 {{ Route::is('nacs-categories') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-apps-2-line text-danger-600"></i></span>
                      <span>Nacs Categories</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('product-categories') }}" class="flex items-center gap-2 {{ Route::is('product-categories') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-price-tag-3-line text-emerald-600"></i></span>
                      <span>Product Categories</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('sale-type') }}" class="flex items-center gap-2 {{ Route::is('sale-type') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-shopping-cart-2-line text-pink-600"></i></span>
                      <span>Sale Types</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('sizes') }}" class="flex items-center gap-2 {{ Route::is('sizes') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-ruler-line text-purple-600"></i></span>
                      <span>Sizes</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('measures') }}" class="flex items-center gap-2 {{ Route::is('measures') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-scales-3-line text-indigo-600"></i></span>
                      <span>Units of Measure</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('terms') }}" class="flex items-center gap-2 {{ Route::is('terms') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-file-list-3-line text-cyan-600"></i></span>
                      <span>Terms</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('bank-account') }}" class="flex items-center gap-2 {{ Route::is('bank-account') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-bank-card-line text-blue-600"></i></span>
                      <span>Bank Account</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('users') }}" class="flex items-center gap-2 {{ Route::is('users') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-user-line text-violet-600"></i></span>
                      <span>Users</span>
                  </a>
              </li>
              @can('manage permissions')
              <li>
                  <a href="{{ route('permissions') }}" class="flex items-center gap-2 {{ Route::is('permissions') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-shield-user-line text-amber-600"></i></span>
                      <span>Permissions</span>
                  </a>
              </li>
              @endcan
          </ul>
      </li>

      {{-- ================= Products ================= --}}
      <li class="dropdown open dropdown-open">
          <a href="javascript:void(0)">
              <iconify-icon icon="ri-box-3-line" class="menu-icon text-green-600"></iconify-icon>
              <span>Products</span> 
          </a>
          <ul class="sidebar-submenu space-y-1">
              <li>
                  <a href="{{ route('products.items') }}" class="flex items-center gap-2 {{ Route::is('products.items') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-stack-line text-gray-600"></i></span>
                      <span>Items</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('promotion.index') }}" class="flex items-center gap-2 {{ Route::is('promotion.*') ? 'active-page' : '' }}">
                      <span class="w-6 flex justify-center"><i class="ri-gift-line text-orange-600"></i></span>
                      <span>Promotion</span>
                  </a>
              </li>
          </ul>
      </li>

      {{-- ================= Price Groups ================= --}}
      <li>
          <a href="{{ route('price-group') }}" class="flex items-center gap-2 {{ Route::is('price-group') ? 'active-page' : '' }}">
              <span class="w-6 flex justify-center"><i class="ri-money-dollar-circle-line text-orange-600"></i></span>
              <span>Price Groups</span>
          </a>
      </li>




    </ul>
  </div>
</aside>

<main class="dashboard-main">
  <div class="navbar-header border-b border-neutral-200 dark:border-neutral-600">
    <div class="flex items-center justify-between">
      <div class="col-auto">
        <div class="flex flex-wrap items-center gap-[16px]">
          <button type="button" class="sidebar-toggle">
            <iconify-icon icon="heroicons:bars-3-solid" class="icon non-active"></iconify-icon>
            <iconify-icon icon="iconoir:arrow-right" class="icon active"></iconify-icon>
          </button>
          <button type="button" class="sidebar-mobile-toggle d-flex !leading-[0]">
            <iconify-icon icon="heroicons:bars-3-solid" class="icon !text-[30px]"></iconify-icon>
          </button>
          <form class="navbar-search">
            <input type="text" name="search" placeholder="Search">
            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
          </form>
          
        </div>
      </div>
      <div class="col-auto">
        <div class="flex flex-wrap items-center gap-3">
          <button type="button" id="theme-toggle" class="w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center">
            <span id="theme-toggle-dark-icon" class="hidden">
              <i class="ri-sun-line"></i>
            </span>
            <span id="theme-toggle-light-icon" class="hidden">
              <i class="ri-moon-line"></i>
            </span>
          </button>  

          <!-- Language Dropdown Start  -->
          <div class="hidden sm:inline-block">
            <button data-dropdown-toggle="dropdownInformation" class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center" type="button">
              <img src="assets/images/lang-flag.png" alt="image" class="w-6 h-6 object-cover rounded-full">
            </button>
            <div id="dropdownInformation" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-lg shadow-lg dropdown-menu-sm p-3">
              <div class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2">
                <div>
                  <h6 class="text-lg text-neutral-900 font-semibold mb-0">Choose Your Language</h6>
                </div>
              </div>

              <div class="max-h-[400px] overflow-y-auto scroll-sm pe-2">
                <div class="mt-4 flex flex-col gap-4">

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="english"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag1.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">English</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="english">
                  </div>

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="Japan"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag2.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">Japan</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="Japan">
                  </div>

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="Franch"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag3.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">Franch</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="Franch">
                  </div>

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="Germany"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag4.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">Germany</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="Germany">
                  </div>

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="SouthKoria"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag5.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">South Koria</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="SouthKoria">
                  </div>

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="Bangladesh"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag6.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">Bangladesh</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="Bangladesh">
                  </div>

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="India"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag7.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">India</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="India">
                  </div>

                  <div class="form-check style-check flex items-center justify-between">
                    <label class="form-check-label line-height-1 font-medium text-secondary-light" for="Koria"> 
                      <span class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3"> 
                        <img src="assets/images/flags/flag8.png" alt="" class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                        <span class="text-base font-semibold mb-0">Koria</span>
                      </span>
                    </label>
                    <input class="form-check-input rounded-full" name="language" type="radio" id="Koria">
                  </div>

                </div>
              </div>
            </div>
          </div>
          <!-- Language Dropdown End  -->


          <!-- Message Dropdown Start  -->
          <button data-dropdown-toggle="dropdownMessage" class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 rounded-full flex justify-center items-center" type="button">
            <iconify-icon icon="mage:email" class="text-neutral-900 dark:text-white text-xl"></iconify-icon>
          </button>
          <div id="dropdownMessage" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-2xl overflow-hidden shadow-lg max-w-[394px] w-full">
            <div class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 m-4 flex items-center justify-between gap-2">
              <h6 class="text-lg text-neutral-900 font-semibold mb-0">Messaage</h6>
              <span class="w-10 h-10 bg-white dark:bg-neutral-600 text-primary-600 dark:text-white font-bold flex justify-center items-center rounded-full">05</span>
            </div>
            <div class="scroll-sm !border-t-0">
              <div class="max-h-[400px] overflow-y-auto">
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative">
                      <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-3.png" alt="Joseph image">
                      <span class="absolute end-[2px] bottom-[2px] w-2.5 h-2.5 bg-success-500 border border-white rounded-full dark:border-gray-600"></span>
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Kathryn Murphy</h6>
                      <p class="mb-0 text-sm line-clamp-1">hey! there i'm...</p>
                    </div>
                  </div>
                  <div class="shrink-0 flex flex-col items-end gap-1">
                    <span class="text-sm text-neutral-500">12:30 PM</span>
                    <span class="w-4 h-4 text-xs bg-warning-600 text-white rounded-full flex justify-center items-center">8</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative">
                      <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-4.png" alt="Joseph image">
                      <span class="absolute end-[2px] bottom-[2px] w-2.5 h-2.5 bg-success-500 border border-white rounded-full dark:border-gray-600"></span>
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Kathryn Murphy</h6>
                      <p class="mb-0 text-sm line-clamp-1">hey! there i'm...</p>
                    </div>
                  </div>
                  <div class="shrink-0 flex flex-col items-end gap-1">
                    <span class="text-sm text-neutral-500">12:30 PM</span>
                    <span class="w-4 h-4 text-xs bg-warning-600 text-white rounded-full flex justify-center items-center">8</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative">
                      <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-5.png" alt="Joseph image">
                      <span class="absolute end-[2px] bottom-[2px] w-2.5 h-2.5 bg-success-500 border border-white rounded-full dark:border-gray-600"></span>
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Kathryn Murphy</h6>
                      <p class="mb-0 text-sm line-clamp-1">hey! there i'm...</p>
                    </div>
                  </div>
                  <div class="shrink-0 flex flex-col items-end gap-1">
                    <span class="text-sm text-neutral-500">12:30 PM</span>
                    <span class="w-4 h-4 text-xs bg-warning-600 text-white rounded-full flex justify-center items-center">8</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative">
                      <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-6.png" alt="Joseph image">
                      <span class="absolute end-[2px] bottom-[2px] w-2.5 h-2.5 bg-success-500 border border-white rounded-full dark:border-gray-600"></span>
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Kathryn Murphy</h6>
                      <p class="mb-0 text-sm line-clamp-1">hey! there i'm...</p>
                    </div>
                  </div>
                  <div class="shrink-0 flex flex-col items-end gap-1">
                    <span class="text-sm text-neutral-500">12:30 PM</span>
                    <span class="w-4 h-4 text-xs bg-warning-600 text-white rounded-full flex justify-center items-center">8</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative">
                      <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-7.png" alt="Joseph image">
                      <span class="absolute end-[2px] bottom-[2px] w-2.5 h-2.5 bg-success-500 border border-white rounded-full dark:border-gray-600"></span>
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Kathryn Murphy</h6>
                      <p class="mb-0 text-sm line-clamp-1">hey! there i'm...</p>
                    </div>
                  </div>
                  <div class="shrink-0 flex flex-col items-end gap-1">
                    <span class="text-sm text-neutral-500">12:30 PM</span>
                    <span class="w-4 h-4 text-xs bg-warning-600 text-white rounded-full flex justify-center items-center">8</span>
                  </div>
                </a>
              </div>

              <div class="text-center py-3 px-4">
                <a href="javascript:void(0)" class="text-primary-600 dark:text-primary-600 font-semibold hover:underline text-center">See All Message </a>
              </div>
            </div>
          </div>
          <!-- Message Dropdown End  -->


          <!-- Notification Start  -->
          <button data-dropdown-toggle="dropdownNotification" class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 rounded-full flex justify-center items-center" type="button">
            <iconify-icon icon="iconoir:bell" class="text-neutral-900 dark:text-white text-xl"></iconify-icon>
          </button>
          <div id="dropdownNotification" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-2xl overflow-hidden shadow-lg max-w-[394px] w-full">
            <div class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 m-4 flex items-center justify-between gap-2">
              <h6 class="text-lg text-neutral-900 font-semibold mb-0">Notification</h6>
              <span class="w-10 h-10 bg-white dark:bg-neutral-600 text-primary-600 dark:text-white font-bold flex justify-center items-center rounded-full">05</span>
            </div>
            <div class="scroll-sm !border-t-0">
              <div class="max-h-[400px] overflow-y-auto">
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative w-11 h-11 bg-success-200 dark:bg-success-600/25 text-success-600 flex justify-center items-center rounded-full">
                      <iconify-icon icon="bitcoin-icons:verify-outline" class="text-2xl"></iconify-icon>
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Congratulations</h6>
                      <p class="mb-0 text-sm line-clamp-1">Your profile has been Verified. Your profile has been Verified</p>
                    </div>
                  </div>
                  <div class="shrink-0">
                    <span class="text-sm text-neutral-500">23 Mins ago</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative">
                      <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-4.png" alt="Joseph image">
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Ronald Richards</h6>
                      <p class="mb-0 text-sm line-clamp-1">You can stitch between artboards</p>
                    </div>
                  </div>
                  <div class="shrink-0">
                    <span class="text-sm text-neutral-500">23 Mins ago</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative w-11 h-11 bg-primary-100 dark:bg-primary-600/25 text-primary-600 flex justify-center items-center rounded-full">
                      AM
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Arlene McCoy</h6>
                      <p class="mb-0 text-sm line-clamp-1">Invite you to prototyping</p>
                    </div>
                  </div>
                  <div class="shrink-0">
                    <span class="text-sm text-neutral-500">23 Mins ago</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative">
                      <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-6.png" alt="Joseph image">
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Annette Black</h6>
                      <p class="mb-0 text-sm line-clamp-1">Invite you to prototyping</p>
                    </div>
                  </div>
                  <div class="shrink-0">
                    <span class="text-sm text-neutral-500">23 Mins ago</span>
                  </div>
                </a>
                <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 relative w-11 h-11 bg-primary-100 dark:bg-primary-600/25 text-primary-600 flex justify-center items-center rounded-full">
                      DR
                    </div>
                    <div>
                      <h6 class="text-sm fw-semibold mb-1">Darlene Robertson</h6>
                      <p class="mb-0 text-sm line-clamp-1">Invite you to prototyping</p>
                    </div>
                  </div>
                  <div class="shrink-0">
                    <span class="text-sm text-neutral-500">23 Mins ago</span>
                  </div>
                </a>
              </div>

              <div class="text-center py-3 px-4">
                <a href="javascript:void(0)" class="text-primary-600 dark:text-primary-600 font-semibold hover:underline text-center">See All Notification </a>
              </div>
            </div>
          </div>
          <!-- Notification End  -->


          <button data-dropdown-toggle="dropdownProfile" class="flex justify-center items-center rounded-full" type="button">
            <img src="assets/images/user.png" alt="image" class="w-10 h-10 object-fit-cover rounded-full">
          </button>
          <div id="dropdownProfile" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-lg shadow-lg dropdown-menu-sm p-3">
            <div class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2">
              <div>
                <h6 class="text-lg text-neutral-900 font-semibold mb-0">Shahidul Islam</h6>
                <span class="text-neutral-500">Admin</span>
              </div>
              <button type="button" class="hover:text-danger-600">
                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon> 
              </button>
            </div>

            <div class="max-h-[400px] overflow-y-auto scroll-sm pe-2">
              <ul class="flex flex-col">
                  <li>
                    <a class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4" href="view-profile.html"> 
                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>  My Profile</a>
                  </li>
                  <li>
                    <a class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4" href="email.html"> 
                    <iconify-icon icon="tabler:message-check" class="icon text-xl"></iconify-icon>  Inbox</a>
                  </li>
                  <li>
                    <a class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4" href="company.html"> 
                    <iconify-icon icon="icon-park-outline:setting-two" class="icon text-xl"></iconify-icon>  Setting</a>
                  </li>
                  <li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit" class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4 w-full text-left">
                              <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> 
                              Log Out
                          </button>
                      </form>
                  </li>

                </ul>
              </div>
            </div>
          </div>


        </div>
    </div>
  </div>
  
  <div class="dashboard-main-body">
        {{ $slot }}
    
  </div>
  <footer class="d-footer">
  <div class="flex items-center justify-between gap-3">
    <p class="mb-0">© 2024 WowDash. All Rights Reserved.</p>
    <p class="mb-0">Made by <span class="text-primary-600">wowtheme7</span></p>
  </div>
</footer>
</main>
  
  <!-- jQuery library js -->
  <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
  <!-- Apex Chart js -->
  <script src="assets/js/lib/apexcharts.min.js"></script>
  <!-- Data Table js -->
  <script src="assets/js/lib/simple-datatables.min.js"></script>
  <!-- Iconify Font js -->
  <script src="assets/js/lib/iconify-icon.min.js"></script>
  <!-- jQuery UI js -->
  <script src="assets/js/lib/jquery-ui.min.js"></script>
  <!-- Vector Map js -->
  <script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
  <script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
  <!-- Popup js -->
  <script src="assets/js/lib/magnifc-popup.min.js"></script>
  <!-- Slick Slider js -->
  <script src="assets/js/lib/slick.min.js"></script>
  <!-- prism js -->
  <script src="assets/js/lib/prism.js"></script>
  <!-- file upload js -->
  <script src="assets/js/lib/file-upload.js"></script>
  <!-- audio player -->
  <script src="assets/js/lib/audioplayer.js"></script>
  
  <script src="assets/js/flowbite.min.js"></script>
  <!-- main js -->
  <script src="assets/js/app.js"></script>

<script src="assets/js/homeOneChart.js"></script>
<script>
    if (document.getElementById("selection-table") && typeof simpleDatatables.DataTable !== 'undefined') {

      let multiSelect = true;
      let rowNavigation = false;
      let table = null;

      const resetTable = function() {
          if (table) {
              table.destroy();
          }

          const options = {
            columns: [
              { select: [0, 6], sortable: false } // Disable sorting on the first column (index 0 and 6)
            ],
              rowRender: (row, tr, _index) => {
                  if (!tr.attributes) {
                      tr.attributes = {};
                  }
                  if (!tr.attributes.class) {
                      tr.attributes.class = "";
                  }
                  if (row.selected) {
                      tr.attributes.class += " selected";
                  } else {
                      tr.attributes.class = tr.attributes.class.replace(" selected", "");
                  }
                  return tr;
              }
          };
          if (rowNavigation) {
              options.rowNavigation = true;
              options.tabIndex = 1;
          }

          table = new simpleDatatables.DataTable("#selection-table", options);

          // Mark all rows as unselected
          table.data.data.forEach(data => {
              data.selected = false;
          });

          table.on("datatable.selectrow", (rowIndex, event) => {
              event.preventDefault();
              const row = table.data.data[rowIndex];
              if (row.selected) {
                  row.selected = false;
              } else {
                  if (!multiSelect) {
                      table.data.data.forEach(data => {
                          data.selected = false;
                      });
                  }
                  row.selected = true;
              }
              table.update();
          });
      };

      // Row navigation makes no sense on mobile, so we deactivate it and hide the checkbox.
      const isMobile = window.matchMedia("(any-pointer:coarse)").matches;
      if (isMobile) {
          rowNavigation = false;
      }

      resetTable();
    }
  </script>
</body>
</html>