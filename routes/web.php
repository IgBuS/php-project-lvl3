<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

Route::post('/domains', function () {
    $url = Request::input('domain');//$request->domain[name];
    $creatTime = Carbon::now()->toDateTimeString();
    DB::insert('insert into domains (name, created_at) values (?, ?)', [$url, $creatTime]);
    return redirect('main');
});

Route::get('/domains', function () {
    $domains = DB::select('select * from domains');
    return view('domains_index', ['domains' => $domains]);
})->name('domains');
