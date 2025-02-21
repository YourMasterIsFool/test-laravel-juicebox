<?php

namespace App\Console\Commands;

use App\Jobs\FetchWeatherData;
use Illuminate\Console\Command;

class FetchOpenWeatherDataByCity extends Command
{




    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'weather:fetch {city}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  "Fetch weather data by city";


    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $city =  $this->argument('city');
        dispatch(new FetchWeatherData($city));

        $this->inf("Weather data fetch job dispatch for {$city}");
    }
}
