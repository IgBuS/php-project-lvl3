<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UrlChechTest extends TestCase
{
    public function testStore()
    {
        $factoryData = Url::factory()->make()->toArray();
        //$data = \Arr::only($factoryData, ['url']);

        $this->post(route('urls.store'), ['url' => $factoryData]);
        $this->assertDatabaseHas('urls', $factoryData);
        $urlId = DB::table('urls')->where('name', $factoryData)->value('id');

        Http::fake([
            // Stub a JSON response for GitHub endpoints...
            '{$factoryData} *' => Http::response("Hello", 200, ['Headers'])
        ]);

        $this->post(route('urls.checks.store', ['url' => $urlId]), ['url' => [
            'id' => $urlId,
        ]]);

        $response = $this->post(route('urls.checks.store', ['url' => $urlId]), ['url' => [
            'id' => $urlId,
        ]]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $urlId,
            'status_code' => 200
        ]);
    }
}
