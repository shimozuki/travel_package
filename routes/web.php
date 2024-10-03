<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

// Rute grup untuk admin
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Admin Dashboard
    Route::group(['middleware' => 'is_admin'], function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // booking only for admin
        Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class)->only(['index', 'destroy']);
        // travel packages for admin
        Route::resource('travel_packages', \App\Http\Controllers\Admin\TravelPackageController::class)->except('show');
        Route::resource('travel_packages.galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['create', 'index', 'show']);
        // categories for admin
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except('show');
        // blogs for admin
        Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->except('show');
        // profile for admin
        Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
        Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

        Route::resource('tickets', \App\Http\Controllers\Ticket_to_Controller::class)->except('show');
        Route::put('/admin/tickets/{id}', '\App\Http\Controllers\Ticket_to_Controller@update');
        // web.php
    });
});

Auth::routes(['register' => true]);

Route::post('admin/bookings/{id}/verify', [\App\Http\Controllers\BookingController::class, 'verify'])->name('admin.bookings.verify');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('homepage');
// travel packages
Route::get('travel-packages', [\App\Http\Controllers\TravelPackageController::class, 'index'])->name('travel_package.index');
Route::get('travel-packages/{travel_package:slug}', [\App\Http\Controllers\TravelPackageController::class, 'show'])->name('travel_package.show');
// blogs
Route::get('blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('blogs/{blog:slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::get('blogs/category/{category:slug}', [\App\Http\Controllers\BlogController::class, 'category'])->name('blog.category');
// contact
Route::get('contact', function () {
    return view('contact');
})->name('contact');
// booking
Route::post('booking', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');

Route::get('/ticket/{id}', [TicketController::class, 'index'])->name('download.ticket');