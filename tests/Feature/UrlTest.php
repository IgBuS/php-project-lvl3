<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;

class UrlTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }


    public function testStore()
    {
        $factoryData = Url::factory()->make()->toArray();
        //$data = \Arr::only($factoryData, ['url']);

        $response = $this->post(route('urls.store'), ['url' => $factoryData]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('urls', $factoryData);
        $response = $this->post(route('urls.store'), ['url' => $factoryData]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testShow()
    {
        $response = $this->get(route('urls.show', 1));
        $response->assertOk();
    }
}
