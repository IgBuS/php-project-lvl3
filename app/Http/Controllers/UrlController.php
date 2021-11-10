<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls')->get();
        return view('domains_index', ['urls' => $urls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'url.name' => 'required|max:255',
        ]);

        $urlName = $request->input('url.name');

        $parsedUrl = parse_url($urlName);

        if (!isset($parsedUrl['scheme'])) {
            flash('The scheme is missed. Add the scheme, please!')->error();
            return redirect()->route('main');
        }
        if (!isset($parsedUrl['host'])) {
            flash('The host is missed. Check the URL, please!')->error();
            return redirect()->route('main');
        }

        $normalizedUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}/";

        $createTime = Carbon::now()->toDateTimeString();

        if (DB::table('urls')->where('name', $normalizedUrl)->doesntExist()) {
            $id = DB::table('urls')->insertGetId(
                ['name' => $normalizedUrl, 'updated_at' => $createTime, 'created_at' => $createTime]
            );
            flash('Url created successfuly')->success();
            return redirect()->route('main');
        } else {
            $id = DB::table('urls')->where('name', $normalizedUrl)->first()->id;
            flash('URL already exists')->warning();
            return redirect()->route('urls.edit', ['url' => $id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = DB::table('urls')->find($id);
        return view('single_url', ['url' => $url]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $updateTime = Carbon::now()->toDateTimeString();
        $affected = DB::table('urls')
              ->where('id', $id)
              ->update(['updated_at' => $updateTime]);
        flash('URL already exists')->warning();
        return redirect()->route('urls.show', ['url' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
