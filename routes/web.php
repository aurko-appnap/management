<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

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
});

Route::get('/item-autocomplete-search' , [Controller::class , 'product_search']);
Route::get('/category-autocomplete-search' , [Controller::class , 'category_search']);
Route::get('/customer-autocomplete-search' , [Controller::class , 'customer_search']);
