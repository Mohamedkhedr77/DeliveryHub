<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) return redirect('/admin');
        if ($user->hasRole('merchant')) return redirect('/merchant');
        if ($user->hasRole('employee')) return redirect('/employee');
        if ($user->hasRole('driver')) return redirect('/driver');
        
        auth()->logout();
        return redirect('/login')->with('error', 'Your account does not have access to any panel.');
    }
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/profile', function () {
        return redirect(auth()->user()->hasRole('admin') ? '/admin/profile' : '/');
    })->name('profile');

});

require __DIR__.'/auth.php';