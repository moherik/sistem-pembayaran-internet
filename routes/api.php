<?php

use App\Http\Controllers\PacketController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user(), 200);
    })->name('me');

    Route::post('/user/update-token', [UserController::class, 'updateFcmToken']);

    Route::group(['prefix' => '/packets', 'as' => 'packet.'], function () {
        Route::get('/', [PacketController::class, 'getAll'])->name('all');
        Route::get('/feed', [PacketController::class, 'feed'])->name('feed');
    });

    Route::group(['prefix' => '/transactions', 'as' => 'transaction.'], function () {
        Route::get('/history', [TransactionController::class, 'history'])->name('history');
        Route::get('/total-payment', [TransactionController::class, 'totalPayment'])->name('totalPayment');
        Route::get('/pay/{orderId}', [TransactionController::class, 'pay'])->name('pay');
        Route::get('/buy/{packetId}', [TransactionController::class, 'buy'])->name('buy');
        Route::get('/check', [TransactionController::class, 'check'])->name('check');
    });

    Route::group(['prefix' => '/tickets', 'as' => 'tickets.'], function () {
        Route::get('/', [TicketController::class, 'me'])->name('me');
        Route::post('/', [TicketController::class, 'create'])->name('create');
        Route::get('/{id}/detail', [TicketController::class, 'detail'])->name('detail');
        Route::post('/{id}/send', [TicketController::class, 'send'])->name('send');
    });
});

Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');
});

Route::get('/transactions/pay-finish', [TransactionController::class, 'payFinish']);
Route::post('/transactions/notification', [TransactionController::class, 'handleMidtransHook']);
Route::get('/notif/{title}/{message}', [TransactionController::class, 'sendNotification']);
