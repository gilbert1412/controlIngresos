<?php

use App\Http\Controllers\Admin\CamposController;
use App\Http\Controllers\Admin\IngresosController;
use App\Http\Controllers\Admin\GuardianesController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');
Route::get('/campos', [CamposController::class, 'index'])->name('campos.index');
Route::get('/guardianes', [GuardianesController::class, 'index'])->name('guardianes.index');
Route::get('/ingresos', [IngresosController::class, 'index'])->name('ingresos.index');

Route::get('/about', function () {
    return view('about');
})->name('about');
