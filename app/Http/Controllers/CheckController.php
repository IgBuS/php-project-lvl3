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
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

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

        if (!$urlName){
            return response()->view('404', [], 404);
        }

        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', $urlName);

            $document = new Document((string) $response->getBody());


            $h1 = optional(optional($document->first('h1')))->text();

            $title = optional(optional($document->first('title')))->text();

            $content = optional(optional($document->first("meta[name='description']")))->getAttribute('content');

            $checkId = DB::table('url_checks')->insertGetId(
                ['url_id' => $urlId,
                'created_at' => $createTime,
                'status_code' => $response->getStatusCode(),
                'h1' => $h1,
                'title' => $title,
                'description' => $content
                ]
            );

        } catch (ConnectException $e) {
            flash(Psr7\Message::toString($e->getRequest()))->error();
            return redirect()->route('urls.show', ['url' => $urlId]);
        } catch (RequestException $e) {
            flash(Psr7\Message::toString($e->getRequest()))->error();
            return redirect()->route('urls.show', ['url' => $urlId]);
        } catch (Exception $e) {
            flash($e->getMessage())->error();
            return redirect()->route('urls.show', ['url' => $urlId]);
        }
        flash('Страница успешно проверена')->success();
        return redirect()->route('urls.show', ['url' => $urlId]);
    }
}
