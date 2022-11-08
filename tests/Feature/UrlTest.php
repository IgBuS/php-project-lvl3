<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;
use App\Models\LongUrl;
use Illuminate\Support\Facades\DB;

class UrlTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $factoryData = Url::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }


    public function testStore()
    {
        $factoryData = Url::factory()->make()->toArray();

        $response = $this->post(route('urls.store'), ['url' => $factoryData]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', $factoryData);
    }

    public function testLongUrl()
    {
        $factoryData = LongUrl::factory()->make()->toArray();

        //long url test
        $response = $this->post(route('urls.store'), ['url' => $factoryData]);
        $response->assertStatus(422);
    }

    public function testShow()
    {
        $urlId = DB::table('urls')->first()->id;
        $response = $this->get(route('urls.show', $urlId));
        $response->assertOk();
    }
}
