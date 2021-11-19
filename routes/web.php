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
    Route::get('/dashboard/notifications/{id}', [NotificationController::class, 'view'])->name('notifications.view');
    Route::get('/dashboard/notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::get('/logout', [DiscordController::class, 'logout'])->name('logout');
});

Route::middleware(['auth.admin'])->group(function () {
    Route::get('/dashboard/users', [AdminController::class, 'users'])->name('dashboard.users');
    Route::get('/dashboard/users/{id}', [AdminController::class, 'user_manage'])->name('dashboard.users.manage');
    Route::get('/dashboard/users/{id}/suspend', [AdminController::class, 'index'])->name('dashboard.users.suspend');
    Route::get('/dashboard/users/{id}/delete', [AdminController::class, 'index'])->name('dashboard.users.delete');

    Route::get('/dashboard/nodes/', [AdminController::class, 'nodes'])->name('dashboard.nodes');
    Route::get('/dashboard/nodes/add', [AdminController::class, 'node_add'])->name('dashboard.nodes.add');
    Route::post('/dashboard/nodes/add', [AdminController::class, 'node_add_store']);
    Route::get('/dashboard/nodes/{id}', [AdminController::class, 'node_manage'])->name('dashboard.nodes.manage');

    Route::get('/dashboard/nests/', [AdminController::class, 'nests'])->name('dashboard.nests');
    Route::get('/dashboard/nests/add', [AdminController::class, 'nest_add'])->name('dashboard.nests.add');
    Route::post('/dashboard/nests/add', [AdminController::class, 'nest_add_store']);
    Route::get('/dashboard/nests/{id}', [AdminController::class, 'nest_manage'])->name('dashboard.nests.id');
    Route::get('/dashboard/nests/{nest_id}/eggs/add', [AdminController::class, 'egg_add'])->name('dashboard.nests.id.eggs.add');
    Route::post('/dashboard/nests/{nest_id}/eggs/add', [AdminController::class, 'egg_add_store']);
    Route::get('/dashboard/nests/{nest_id}/eggs/{egg_id}', [AdminController::class, 'egg_manage'])->name('dashboard.nests.id.eggs.manage');
});

// This is for 69 th commit on github :D