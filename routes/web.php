<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

// use App\Mail\WarrantyInvitation;
// use App\Mail\WarrantyNearExpiry;
// use App\Mail\WarrantyExpired;
// use App\Models\Warranty;

/**
 * Guest Routes
 */
Route::middleware('guest')->group(function () {

    // Static Route
    Route::view('/', 'index');

    // Google OAuth Route
    Route::get('/auth/google', [SocialiteController::class, 'googleLogin'])->name('auth.google');
    Route::get('/auth/google-callback', [SocialiteController::class, 'googleAuthentication'])->name('auth.google-callback');

    // Customer Registration Warranty Claim
    Route::get('/register/claim/{serial}', [WarrantyController::class, 'show'])->name('customer.claim')->middleware('signed');

}); 

/**
 * Customer Routes
 */ 
Route::middleware(['auth', 'customer', 'verified'])->group(function () {

    Route::get('/home', [CustomerController::class, 'index'])->name('home');
    Route::get('/warranty', [CustomerController::class, 'list'])->name('warranty');
    Route::get('/history', [CustomerController::class, 'history'])->name('history');
    Route::get('/replacement', [CustomerController::class, 'replacement'])->name('replacement');
    Route::get('/warranty/{id}', [CustomerController::class, 'show'])->name('warranty.show');

    Route::post('/send-inquiry', [WarrantyController::class, 'inquire'])->name('inquire-warranty'); 

});

/**
 * Admin and Staff Routes
 */
Route::middleware(['auth', 'manager'])->group(function () {

    // Asidebar Routes
    Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard');
    Route::get('/register-warranty', [ManagerController::class, 'register'])->name('register-warranty');
    Route::get('/active-warranties', [ManagerController::class, 'activeWarranties'])->name('active-warranties');
    Route::get('/warranty-inquiries', [ManagerController::class, 'warrantyInquiries'])->name('warranty-inquiries');
    Route::get('/inquiry-response/{id}', [ManagerController::class, 'inquiryResponse'])->name('inquiry-action');
    Route::get('/active-warranties', [ManagerController::class, 'activeWarranties'])->name('active-warranties');
    Route::get('/customers', [ManagerController::class, 'customers'])->name('customers');
    Route::get('/reports', [ManagerController::class, 'reports'])->name('reports');
    Route::get('/staff-accounts', [ManagerController::class, 'staffAccounts'])->name('staff-accounts');
    Route::get('/manager/profile', [ManagerController::class, 'profile'])->name('manager.profile');

    // Warranty
    Route::post('/register-warranty', [WarrantyController::class, 'store'])->name('register-warranty-details');
    Route::post('/response', [WarrantyController::class, 'response'])->name('response');
    Route::patch('/warranty-status/{id}', [WarrantyController::class, 'update']);
    
    // Product
    Route::get('/products', [ProductController::class, 'index'])->name('add-product');
    Route::post('/products', [ProductController::class, 'store'])->name('store-product');
    Route::put('/products', [ProductController::class, 'update'])->name('update-product');
    Route::delete('/products', [ProductController::class, 'destroy'])->name('delete-product');

});

/**
 * Laravel Breeze Routes
 */
Route::middleware('auth')->group(function () {

    // Add a policy.....
    Route::post('/send-response', [WarrantyController::class, 'response'])->name('inquiry-response');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';



// Route to view the email that will be sent to the user
// Route::get('/preview-mail', function () {

//     $warranty = Warranty::whereNotNull('user_id')->first();

//     // return new WarrantyInvitation($warranty, 'test@gmail.com','');
//     // return new WarrantyNearExpiry($warranty);
//     return new WarrantyExpired($warranty);
// });