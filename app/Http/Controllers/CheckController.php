<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use DiDom\Document;
use Exception;

class CheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $urlId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $urlId)
    {

        $createTime = Carbon::now()->toDateTimeString();
        $urlName = DB::table('urls')->where('id', $urlId)->value('name');
        try {
            $response = Http::get($urlName);

            //$document = new Document($urlName, true);
            $document = new Document($response->body());


            $h1 = optional(optional($document->find('h1'))[0])->text();

            $title = optional(optional($document->find('title'))[0])->text();

            $content = optional(optional($document->find("meta[name='description']"))[0])->getAttribute('content');

            $checkId = DB::table('url_checks')->insertGetId(
                ['url_id' => $urlId,
                'created_at' => $createTime,
                'status_code' => $response->status(),
                'h1' => $h1,
                'title' => $title,
                'description' => $content
                ]
            );
        } catch (Exception $e) {
            flash($e->getMessage())->error();
            return redirect()->route('urls.show', ['url' => $urlId]);
        }
        flash('Страница успешно проверена')->success();
        return redirect()->route('urls.show', ['url' => $urlId]);
    }
}
