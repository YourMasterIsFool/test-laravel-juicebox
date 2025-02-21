<?php

namespace App\Jobs;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchWeatherData implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $city;

    public function __construct($city)
    {
        $this->city =  $city;
    }

    /**
     * Create a new job instance.
     */


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $cacheKey = 'weather_{$this->city}';

        $apiKey =  config('services.openweather.key');
        $url =  config('services.openweather.url');

        $apiKey = config('services.openweather.key');
        $url = config('services.openweather.url');


        try {
            $response = Http::get($url, [
                'q' => $this->city,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);

            if ($response->successful()) {
                Cache::put($cacheKey, $response->json(), now()->addHour());
            }
        } catch (RequestException $e) {

            \Log::error("Failed to fetch weather");
        }
    }
}
