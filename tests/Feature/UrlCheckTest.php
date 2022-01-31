<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;

class UrlChechTest extends TestCase
{
    public function testStore()
    {
        $factoryData = Url::factory()->make()->toArray();
        //$data = \Arr::only($factoryData, ['url']);

        $this->post(route('urls.store'), ['url' => $factoryData]);
        $this->assertDatabaseHas('urls', $factoryData);
        $this->post(route('urls.checks.store', ['url'=>1]), ['url' => [
            'id' => 1,
        ]]);
        $response = $this->post(route('urls.checks.store', ['url'=>1]), ['url' => [
            'id' => 1,
        ]]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseCount('url_checks', 2);
        $this->assertDatabaseHas('url_checks', [
            'url_id' => 1,
        ]);

    }
}