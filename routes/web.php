<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

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
    $url = $request->input("domain[name]");
    $creatTime = Carbon::now()->toDateTimeString();
    $id = DB::table('domains')->insertGetId(
        ['name' => $url, 'updated_at' => $creatTime, 'created_at' => $creatTime]
    );
    return redirect()->route('main');
});

Route::get('/domains', function () {
    $domains = DB::select('select * from domains');
    return view('domains_index', ['domains' => $domains]);
})->name('domains');
