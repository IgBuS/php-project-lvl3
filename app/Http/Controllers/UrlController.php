<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestChecks = DB::table('url_checks')
                   ->select('url_id', DB::raw('MAX(created_at) as last_check_created_at'))
                   ->groupBy('url_id')
                   ->pluck('last_check_created_at', 'url_id')
                   ->toArray();

        $urls = DB::table('urls')
                ->orderBy('urls.id', 'asc')
                ->paginate(15);

        return view('index', ['urls' => $urls, 'latestChecks' => $latestChecks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $rules = [
            'url.name' => 'required|max:255',
        ];

        $messages = [
            'max' => 'Некорректный URL',
            'required' => 'URL не должен быть пустым'
        ];

        $validated = $request->validate($rules, $messages);

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

        $normalizedUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";

        $createTime = Carbon::now()->toDateTimeString();

        if (DB::table('urls')->where('name', $normalizedUrl)->doesntExist()) {
            $id = DB::table('urls')->insertGetId(
                ['name' => $normalizedUrl, 'updated_at' => $createTime, 'created_at' => $createTime]
            );
            flash('Страница успешно добавлена')->success();
            return redirect()->route('urls.show', ['url' => $id]);
        } else {
            $id = DB::table('urls')->where('name', $normalizedUrl)->value('id');
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
        if (!$url){
            return response()->view('404', [], 404);
        }
        $checks = DB::table('url_checks')
            ->where('url_id', '=', $id)
            ->latest()
            ->paginate(5);

        return view('show', ['url' => $url, 'checks' => $checks]);
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
}
