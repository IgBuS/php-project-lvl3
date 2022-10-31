<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UrlCheckTest extends TestCase
{
    public function testStore()
    {
        $factoryData = Url::factory()->make()->toArray();
        $this->post(route('urls.store'), ['url' => $factoryData]);
        $this->assertDatabaseHas('urls', $factoryData);
        $urlId = DB::table('urls')->where('name', $factoryData)->value('id');
        Http::fake([
            "{$factoryData['name']}*" => Http::response([], 200, [])
        ]);
        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $urlId,
            'status_code' => 200
        ]);
    }
}
