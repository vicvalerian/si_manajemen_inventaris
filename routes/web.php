<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

//Admin All Route
Route::controller(AdminController::class)->group(function (){
    Route::get('/admin/logout', 'destroy')->name('admin.logout');

    Route::get('/admin/profile', 'profile')->name('admin.profile');

    Route::get('/edit/profile', 'edit')->name('edit.profile');
    Route::post('/store/profile', 'storeProfile')->name('store.profile');

    Route::get('/change/password', 'changePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
