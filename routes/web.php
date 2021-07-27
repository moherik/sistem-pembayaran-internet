<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Packet\Show as PacketShow;
use App\Http\Livewire\Packet\Form;
use App\Http\Livewire\Ticket\Show as TicketShow;
use App\Http\Livewire\Ticket\Detail;
use App\Http\Livewire\Transaction\Show as TransactionShow;
use App\Http\Livewire\User\Show as UserShow;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth:sanctum', 'verified', 'admin']], function () {

    Route::get('/', Dashboard::class)->name('dashboard');

    Route::group(['prefix' => '/packet', 'as' => 'packet.'], function () {
        Route::get('/', PacketShow::class)->name('show');
        Route::get('/{formType}/{packetId?}', Form::class)->name('form');
    });

    Route::get('/transaction', TransactionShow::class)->name('transaction');

    Route::get('/user', UserShow::class)->name('user');

    Route::group(['prefix' => '/ticket', 'as' => 'ticket.'], function () {
        Route::get('/', TicketShow::class)->name('show');
        Route::get('/{ticketId}', Detail::class)->name('detail');
    });
});

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => $password
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('password.complete')
                : redirect()->route('password.error');
})->middleware('guest')->name('password.update');

Route::get('/reset/complete', function (Request $request) {
    echo 'Berhasil melakukan reset password';
})->middleware('guest')->name('password.complete');

Route::get('/reset/error', function (Request $request) {
    echo 'Gagal melakukan reset password';
})->middleware('guest')->name('password.error');
