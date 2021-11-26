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
    // Auth: Login and Register
    Route::get('/login', [DiscordController::class, 'build_url'])->name('login');
    Route::get('/login/token', [DiscordController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    // Overview
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notificaations
    Route::get('/dashboard/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/dashboard/notifications/{id}', [NotificationController::class, 'view'])->name('notifications.view');
    Route::get('/dashboard/notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete');

    // Auth: Logout
    Route::get('/logout', [DiscordController::class, 'logout'])->name('logout');
});

Route::middleware(['auth.admin'])->group(function () {
    // Users
    Route::get('/dashboard/users', [AdminController::class, 'users'])->name('dashboard.users');
    Route::get('/dashboard/users/{id}', [AdminController::class, 'user_manage'])->name('dashboard.users.id');
    Route::get('/dashboard/users/{id}/toggle', [AdminController::class, 'user_toggle'])->name('dashboard.users.id.toggle');
    Route::get('/dashboard/users/{id}/delete', [AdminController::class, 'index'])->name('dashboard.users.id.delete');

    // Nodes
    Route::get('/dashboard/nodes/', [AdminController::class, 'nodes'])->name('dashboard.nodes');
    Route::get('/dashboard/nodes/add', [AdminController::class, 'node_add'])->name('dashboard.nodes.add');
    Route::post('/dashboard/nodes/add', [AdminController::class, 'node_add_store']);
    Route::get('/dashboard/nodes/{id}', [AdminController::class, 'node_manage'])->name('dashboard.nodes.id');
    Route::get('/dashboard/nodes/{id}/toggle', [AdminController::class, 'node_toggle'])->name('dashboard.nodes.id.toggle');

    // Nests and eggs
    Route::get('/dashboard/nests/', [AdminController::class, 'nests'])->name('dashboard.nests');
    Route::get('/dashboard/nests/add', [AdminController::class, 'nest_add'])->name('dashboard.nests.add');
    Route::post('/dashboard/nests/add', [AdminController::class, 'nest_add_store']);
    Route::get('/dashboard/nests/{id}', [AdminController::class, 'nest_manage'])->name('dashboard.nests.id');
    Route::get('/dashboard/nests/{id}/toggle', [AdminController::class, 'nest_toggle'])->name('dashboard.nests.id.toggle');
    Route::get('/dashboard/nests/{id}/resync', [AdminController::class, 'nest_resync'])->name('dashboard.nests.id.resync');
    Route::get('/dashboard/nests/{nest_id}/eggs/add', [AdminController::class, 'egg_add'])->name('dashboard.nests.id.eggs.add');
    Route::post('/dashboard/nests/{nest_id}/eggs/add', [AdminController::class, 'egg_add_store']);
    Route::get('/dashboard/nests/{nest_id}/eggs/{egg_id}', [AdminController::class, 'egg_manage'])->name('dashboard.nests.id.eggs.id');
    Route::post('/dashboard/nests/{nest_id}/eggs/{egg_id}', [AdminController::class, 'egg_update']);
    Route::get('/dashboard/nests/{nest_id}/eggs/{egg_id}/toggle', [AdminController::class, 'egg_toggle'])->name('dashboard.nests.id.eggs.id.toggle');
    Route::get('/dashboard/nests/{nest_id}/eggs/{egg_id}/resync', [AdminController::class, 'egg_resync'])->name('dashboard.nests.id.eggs.id.resync');
});
