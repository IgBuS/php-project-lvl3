<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $parsedUrl = parse_url($this->faker->url);
        $normalizedUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";
        return [
            'name' => $normalizedUrl
        ];
    }

    /**
     * Define the model's state for long url.
     *
     * @return array
     */
    public function longUrl()
    {
        $parsedUrl = parse_url($this->faker->url);
        $normalizedUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";
        $longUrl = "{$normalizedUrl}/{$this->faker->text(300)}";
        return [
            'name' => $longUrl
        ];
    }
}
