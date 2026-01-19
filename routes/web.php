<?php

use App\Livewire\AttachUserLocation;
use App\Livewire\BankAccountForm;
use App\Livewire\DepartmentForm;
use App\Livewire\ItemComponent;
use App\Livewire\LocationComponent;
use App\Livewire\MinAgeComponent;
use App\Livewire\NacsCategoryComponent;
use App\Livewire\PayeeForm;
use App\Livewire\PermissionComponent;
use App\Livewire\PriceGroupComponent;
use App\Livewire\Product\PriceGroup\IndexComponent;
use App\Livewire\Product\PriceGroup\ItemListComponent;
use App\Livewire\ProductCategoryComponent;
use App\Livewire\ProductComponent;
use App\Livewire\Promotion\PromotionComponent;
use App\Livewire\SaleTypeComponent;
use App\Livewire\SizeComponent;
use App\Livewire\TermForm;
use App\Livewire\UnitOfMeasureComponent;
use App\Livewire\UserForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::redirect('/', 'login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/payees', PayeeForm::class)->name('payees');
    Route::get('/departments', DepartmentForm::class)->name('departments');
    Route::get('/ages', MinAgeComponent::class)->name('ages');
    Route::get('/nacs-categories', NacsCategoryComponent::class)->name('nacs-categories');
    Route::get('/product-categories', ProductCategoryComponent::class)->name('product-categories');
    Route::get('/sale-type', SaleTypeComponent::class)->name('sale-type');
    Route::get('/sizes', SizeComponent::class)->name('sizes');
    Route::get('/measures', UnitOfMeasureComponent::class)->name('measures');
    Route::get('/terms', TermForm::class)->name('terms');
    Route::get('/items', ItemComponent::class)->name('items');
    Route::get('/bank-account', BankAccountForm::class)->name('bank-account');
    Route::get('/price-group', PriceGroupComponent::class)->name('price-group');
    Route::get('/product-items', ProductComponent::class)->name('products.items');
    Route::get('product/pricebook', IndexComponent::class)->name('products.pricebook.index');
    Route::get('/promotion', PromotionComponent::class)->name('promotion.index');
    Route::get('/locations', LocationComponent::class)->name('locations');
    Route::get('attach/location', AttachUserLocation::class)->name('attach-locations');
    Route::get('/users', UserForm::class)->name('users');
    Route::get('/permissions', PermissionComponent::class)->middleware('can:manage permissions')->name('permissions');
});

require __DIR__.'/auth.php';
Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::get('migrate', function() {
    $exitCode = Artisan::call('migrate');
   
});