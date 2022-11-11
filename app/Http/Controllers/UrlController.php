<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
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
                   ->select('url_id', DB::raw('MAX(created_at) as last_check_created_at'), 'status_code')
                   ->groupBy('url_id', 'status_code');

        $latestChecksDates = $latestChecks->pluck('last_check_created_at', 'url_id')
                    ->toArray();

        $latestChecksStatuses = $latestChecks->pluck('status_code', 'url_id')
                    ->toArray();

        $urls = DB::table('urls')
                ->orderBy('urls.id', 'asc')
                ->paginate(15);

        return view('index', ['urls' => $urls, 'latestChecksDates' => $latestChecksDates, 'latestChecksStatuses' => $latestChecksStatuses]);
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
            'url.name' => 'required|max:255|url',
        ];

        $messages = [
            'max' => 'Некорректный URL',
            'url' => 'Некорректный URL',
            'required' => 'URL не должен быть пустым'
        ];

        $validator = Validator::make($input, $rules, $messages);
        $errors = $validator->errors();
        $viewErrorBag = new \Illuminate\Support\ViewErrorBag();
        $viewErrorBag->__set('default', $errors);

        if ($validator->fails()) {
            $data = [
                'errors' => $viewErrorBag,
                'input' => $input
            ];
        /** @var  \Illuminate\Support\Facades\Response  $view */
            $view = response();
            return $view
                ->view('main', $data, 422);
        }

        $urlName = $request->input('url.name');
        $parsedUrl = parse_url($urlName);
        $normalizedUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";

        $createTime = Carbon::now()->toDateTimeString();

        $urlId = DB::table('urls')->where('name', $normalizedUrl)->value('id');

        if (!$urlId) {
            $newUrlId = DB::table('urls')->insertGetId(
                ['name' => $normalizedUrl, 'created_at' => $createTime]
            );
            flash('Страница успешно добавлена')->success();
            return redirect()->route('urls.show', ['url' => $newUrlId]);
        } else {
            flash('Страница уже существует')->warning();
            return redirect()->route('urls.show', ['url' => $urlId]);
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

        abort_unless($url, 404);

        $checks = DB::table('url_checks')
            ->where('url_id', $id)
            ->latest()
            ->paginate(5);

        return view('show', ['url' => $url, 'checks' => $checks]);
    }
}
