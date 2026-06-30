<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;

Route::get('/', function () {
    return view('welcome');
});

// مسارات محمية بتسجيل الدخول
Route::middleware(['auth', 'verified'])->group(function () {



    // 2. مسارات التاجر
    Route::middleware(['role:merchant'])->prefix('merchant')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>لوحة تحكم التاجر - إضافة الأوردرات</h1>';
        })->name('merchant.dashboard');
    });

    // 3. مسارات الموظف
    Route::middleware(['role:employee'])->prefix('employee')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>لوحة تحكم الموظف - تعيين الدليفري</h1>';
        })->name('employee.dashboard');
    });

    // 4. مسارات الدليفري
    Route::middleware(['role:driver'])->prefix('driver')->group(function () {
        Route::get('/dashboard', function () {
            return view('driver.dashboard');
        })->name('driver.dashboard');
    });
    Route::get('/profile', function () {
        return 'Profile Page';
        })->name('profile');
    Route::get('/driver/orders', function () {
        return view('driver.orders');
        })->name('driver.orders');


Route::post('/driver/orders/{order}/update-status', function (
    \Illuminate\Http\Request $request,
    \App\Models\Order $order
) {

    $order->update([
        'status_id' => $request->status_id
    ]);

    return redirect()->route('driver.my-orders');

})->name('driver.orders.update-status');

    Route::get('/driver/new-orders', function () {
    return view('driver.new-orders');
})->name('driver.new-orders');

Route::get('/driver/my-orders', function () {
    return view('driver.my-orders');
})->name('driver.my-orders');

Route::get('/driver/delivered-orders', function () {
    return view('driver.delivered-orders');
})->name('driver.delivered-orders');

Route::get('/driver/returned-orders', function () {
    return view('driver.returned-orders');
})->name('driver.returned-orders');

Route::post('/driver/orders/{order}/accept', function (Order $order) {

    $order->update([
        'driver_id' => auth()->id(),
        'status_id' => 2
    ]);

    return redirect()->route('driver.my-orders');

})->name('driver.accept');

Route::post('/driver/orders/{order}/reject', function (Order $order) {

    $order->update([
        'driver_id' => null,
        'status_id' => 6   // Rejected by Driver
    ]);

    return redirect()->route('driver.new-orders');

})->name('driver.reject');
});
    

// ملف مسارات الـ Auth الافتراضي لـ Breeze
require __DIR__.'/auth.php';