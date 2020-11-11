<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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
    return view('main');
})->name('main');

Route::post('/domains', function (Request $request) {
    $url = $request->input('domain[name]');
    $creatTime = Carbon::now()->toDateTimeString();
    DB::insert('insert into domains (name, created_at) values (?, ?)', [$url, $creatTime]);
    return view('main');
})
