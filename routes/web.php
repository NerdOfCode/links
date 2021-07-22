<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinksController;

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

Route::get('/', [LinksController::class, 'linksHome']);
Route::get('delete-link/{id}', [LinksController::class, 'deleteLink']);
Route::get('logout', [LinksController::class, 'accountLogout']);
Route::post('store-link', [LinksController::class, 'storeLink']);
Route::post('account-name', [LinksController::class, 'accountName']);
