<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $stats = [
        'total_products' => \App\Models\Product::count(),
        'low_stock' => \App\Models\Product::whereColumn('stock_quantity', '<=', 'minimum_stock')->count(),
        'today_sales' => \App\Models\Sale::whereDate('created_at', today())->count(),
        'today_revenue' => \App\Models\Sale::whereDate('created_at', today())->sum('total'),
    ];
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);
    Route::get('/products/low-stock/list', [ProductController::class, 'lowStock'])->name('products.low-stock');
    Route::get('/products/search/api', [ProductController::class, 'search'])->name('products.search');

    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/process-sale', [POSController::class, 'processSale'])->name('pos.process-sale');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');

    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
