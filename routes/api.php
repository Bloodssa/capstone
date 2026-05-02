<?php

use App\Http\Controllers\Api\InquiryMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json(['allahuakbar']);
});

Route::get('/messages', [InquiryMessageController::class, 'index']);
Route::post('/messages', [InquiryMessageController::class, 'store']);
Route::get('/messages/{id}', [InquiryMessageController::class, 'show']);
Route::put('/messages/{id}', [InquiryMessageController::class, 'update']);
Route::delete('/messages/{id}', [InquiryMessageController::class, 'destroy']);


// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/messages', [InquiryMessageController::class, 'index']);
//     Route::get('/messages/{id}', [InquiryMessageController::class, 'show']);
// });


Route::get('/test', function() {
    return response()->json(['status' => 'I am alive']);
});