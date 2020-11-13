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

Route::post('/domains', function (Request $request) {
    $url = $request->input('domain[name]');
    $creatTime = Carbon::now();
    DB::insert('insert into domains (name, created_at) values (?, ?)', [$url, $creatTime]);
    return view('main');
});

Route::get('/domains', function () {
    $domains = ['id' => 'id', 'nmae' => 'name', 'created_at' => 'created_at', 'updated_at' => "updated_at"];//DB::select('select * from domains ORDER BY id ASC');
    return view('domains.index', ['domains' => $domains]);
})->name('domains');
