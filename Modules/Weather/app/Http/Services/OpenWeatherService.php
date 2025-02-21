<?php

namespace Modules\Weather\Http\Services;

use Error;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OpenWeatherService
{
    public function getWeather(string $city)
    {


        $cacheKey = "weather_" . $city;

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($city) {
            $apiKey = config('services.openweather.key');
            $url = config('services.openweather.url');


            try {
                $response = Http::get($url, [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric'
                ]);

                if ($response->failed()) {
                    return [
                        'error' => true,
                        'message' => $this->handleErrorFromAPI($response)
                    ];
                }

                return [
                    'error' => false,
                    'data' => $response->json()
                ];
            } catch (RequestException $e) {
                return [
                    'error' => true,
                    'message' => 'Gagal mengambil data weather'
                ];
            }
        });
    }

    private function handleErrorFromAPI($response)
    {
        if ($response->status() === 401) {
            return "Invalid API key. Please check your OpenWeather API key.";
        } elseif ($response->status() === 404) {
            return "City not found. Please enter a valid city name.";
        } elseif ($response->status() === 429) {
            return "Too many requests. You've exceeded your OpenWeather API limit.";
        } else {
            return "Unexpected error occurred. Please try again later.";
        }
    }
}
