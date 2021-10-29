<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DiscordController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\NotificationController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', [DiscordController::class, 'build_url'])->name('login');
    Route::get('/login/token', [DiscordController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/dashboard/notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::get('/logout', [DiscordController::class, 'logout'])->name('logout');
});

Route::middleware(['auth.admin'])->group(function () {
    Route::get('/dashboard/users', [AdminController::class, 'index'])->name('dashboard.users');
    Route::get('/dashboard/users/{id}', [AdminController::class, 'index'])->name('dashboard.users.manage');
    Route::get('/dashboard/users/{id}/suspend', [AdminController::class, 'index'])->name('dashboard.users.suspend');
    Route::get('/dashboard/users/{id}/delete', [AdminController::class, 'index'])->name('dashboard.users.delete');
});
