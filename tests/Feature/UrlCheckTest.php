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
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testStore()
    {
        $factoryData = Url::factory()->make()->toArray();
        $response = $this->post(route('urls.store'), ['url' => $factoryData]);
        $urlId = DB::table('urls')->where('name', $factoryData)->value('id');
        $html = file_get_contents(__DIR__ . "/../fixtures/test.html");

        Http::fake([
            '*' => Http::response($html, 200, [])
        ]);
        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $urlId,
            'status_code' => 200,
            'h1' => "My Test Heading",
            'title' => "Test title",
            'description' => "Test description"
        ]);
    }
}
