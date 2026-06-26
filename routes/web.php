<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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

    // 4. مسارات الدليفري - صفحة واحدة فيها كل حاجة
    Route::middleware(['role:driver'])->group(function () {
        Route::get('/dashboard', \App\Livewire\Driver\OrderBoard::class)
            ->name('driver.dashboard');
    });
});

// ملف مسارات الـ Auth الافتراضي لـ Breeze
require __DIR__.'/auth.php';
