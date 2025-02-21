<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Modules\Post\Models\Post;

uses(Tests\TestCase::class, DatabaseTransactions::class);

it("Test Endpoint Weather Data", function () {

    $city =  "Perth";
    Http::fake([
        'api.openweathermap.org/*' => Http::response([
            'main' => ['temp' => 25],
            'weather' => [['description' => 'clear sky']],
            'name' => $city
        ], 200)
    ]);

    Cache::forget('weather_{$city}');

    $response = $this->getJson('/api/weather?city={$city}');
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'main' => [
                    "temp" => 25
                ],
                "weather" => [
                    ["description" => "clear sky"]
                ],
                "name" => "{$city}"
            ]
        ]);

    $this->assertTrue(Cache::has('weather_{$city}'));

    $cachedData = Cache::get('weather_{$city}');
    $this->assertEquals(25, $cachedData['data']['main']['temp']);

    $this->assertEquals('clear sky', $cachedData['data']['weather'][0]['description']);
});


it("test weather endpoint failure", function () {

    Http::fake([
        'api.openweathermap.org/*' => Http::response([], 500)
    ]);


    $response = $this->getJson('/api/weather?city=Jakarta');


    // Assert the response structure
    $response->assertStatus(500)
        ->assertJsonValidationErrors([
            "error" => true
        ]);
});
