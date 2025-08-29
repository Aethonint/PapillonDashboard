<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;


/*
|--------------------------------------------------------------------------
| Landing & Login Routes
|--------------------------------------------------------------------------
| '/' will redirect logged-in users to their dashboard
| Guests will see the login page
*/
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.index')
            : redirect()->route('user.index');
    }
    return view('auth.login');
})->name('home')->middleware('web'); // only web middleware, no guest here

/*
|--------------------------------------------------------------------------
| Authentication Routes (Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Logout (Shared for all roles)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Profile Routes (Shared for all roles)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/admin/home', [AdminDashboardController::class, 'index'])->name('admin.index');
     Route::get('/admin/Dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminDashboardController::class, 'adminprofile'])->name('admin.profile');
    Route::get('/admin/edit', [AdminDashboardController::class, 'changepassword'])->name('admin.changepassword');
    // Vehicle List Index
    Route::get('/vehicle/list', [VehicleController::class, 'index'])->name('vehicle.index');
      Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');



      // Category route list 
      Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
      Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
            Route::POST('/category/store', [CategoryController::class, 'store'])->name('category.store');
     Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
     Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
     Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

     //All products routes
     Route::get('/product', [ProductController::class, 'index'])->name('product.index');
      Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
            Route::POST('/product/store', [ProductController::class, 'store'])->name('product.store');
     Route::get('/product/{category}/edit', [ProductController::class, 'edit'])->name('product.edit');
     Route::put('/product/{category}', [ProductController::class, 'update'])->name('product.update');
     Route::delete('/product/{category}', [ProductController::class, 'destroy'])->name('product.destroy');

   
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/user/home', [UserController::class, 'index'])->name('user.index');
});

require __DIR__.'/auth.php';
