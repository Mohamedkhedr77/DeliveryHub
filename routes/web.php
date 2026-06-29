<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
<<<<<<< Updated upstream
use Livewire\Volt\Volt;
=======
use App\Livewire\Driver\Dashboard as DriverDashboard;
>>>>>>> Stashed changes
=======
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5

Route::get('/', function () {
    return view('welcome');
});

// مسارات محمية بتسجيل الدخول
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. مسارات الأدمن
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>لوحة تحكم أدمن السيستم</h1>';
        })->name('admin.dashboard');
    });

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

<<<<<<< HEAD
<<<<<<< Updated upstream
    // 4. مسارات الدليفري - صفحة واحدة فيها كل حاجة
    Route::middleware(['role:driver'])->group(function () {
        Route::get('/dashboard', \App\Livewire\Driver\OrderBoard::class)
=======
    // 4. مسارات الدليفري
    Route::middleware(['role:driver'])->prefix('driver')->group(function () {
        Route::get('/dashboard', DriverDashboard::class)
>>>>>>> Stashed changes
            ->name('driver.dashboard');
    });

    // Profile route
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

// ملف مسارات الـ Auth الافتراضي لـ Breeze
require __DIR__.'/auth.php';
=======
    // 4. مسارات الدليفري
    Route::middleware(['role:driver'])->prefix('driver')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>لوحة تحكم الكابتن/الدليفري</h1>';
        })->name('driver.dashboard');
    });
});

// ملف مسارات الـ Auth الافتراضي لـ Breeze
require __DIR__.'/auth.php';
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
