<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('/login', 'Api\AuthController@login');

//Route::post('register', [AuthController::class, 'register']);

Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('register', [App\Http\Controllers\API\AuthController::class, 'register']);


// Route::post('login', function () {
    //   return 5;
    // });
Route::group(['middleware' => ['auth:api']], function () {

    Route::get('user', function (Request $request) {
        $user = auth()->user();
        $user->balance = $user->getBalance();
        return $user;
    });
        
    Route::get('logout', [App\Http\Controllers\API\AuthController::class, 'logout']);


    Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');
    Route::post('stripeWithdraw', [StripePaymentController::class, 'stripeWithdraw'])->name('stripe.withdraw');

    Route::get('/users', [StripePaymentController::class, 'users']);
    Route::get('/operators', [StripePaymentController::class, 'operators']);

    Route::get('/transactions', [StripePaymentController::class, 'transactions']);
    Route::get('/withdrawals', [StripePaymentController::class, 'withdrawals']);

    Route::get('/user_transactions', [StripePaymentController::class, 'user_transactions']);
    Route::get('/user_withdrawals', [StripePaymentController::class, 'user_withdrawals']);


    // Route::post('changePassword', [App\Http\Controllers\API\AuthController::class, 'changePassword']);
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     $user = $request->user();
//     $user->balance = $user->getBalance();
//     return $user;
// });