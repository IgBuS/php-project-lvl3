<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Request;
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
                   ->groupBy('url_id');

        $urls = DB::table('urls')
                ->leftJoinSub($latestChecks, 'latest_checks', function ($join) {
                    $join->on('urls.id', '=', 'latest_checks.url_id');
                })->orderBy('urls.id', 'asc')
                ->paginate(15);

        return view('domains_index', ['urls' => $urls]);
    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
/*         $request->validate([
            'url.name' => 'required|max:255',
        ]); */
        $input = $request->all();

        $rules = [
            'url.name' => 'required|max:255',
        ];

        $messages = [
            'max' => 'Некорректный URL',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
             return redirect()->route('main')
                        ->withErrors($validator)
                        ->withInput();
        }

        $urlName = $request->input('url.name');



        if (filter_var($urlName, FILTER_VALIDATE_URL) != true) {
            flash('Адрес не прошел валидацию =(')->error();
            return redirect()->route('main');
        }

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
            flash('Url created successfuly')->success();
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
        $checks = DB::table('url_checks')->where('url_id', '=', $id)->orderByDesc('id')->get();
        return view('single_url', ['url' => $url, 'checks' => $checks]);
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
