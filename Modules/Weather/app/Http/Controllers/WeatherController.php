<?php

namespace Modules\Weather\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Weather\Http\Services\OpenWeatherService;
use RakibDevs\Weather\Weather;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected  OpenWeatherService $openWeatherService;
    public function __construct(OpenWeatherService $openWeatherService)
    {
        $this->openWeatherService = $openWeatherService;
    }
    public function index(Request $request)
    {
        $city = $request->query('city', 'Perth'); // Default city: Jakarta
        $weather = $this->openWeatherService->getWeather($city);



        if ($weather['error']) {
            return $this->sendErrorResponse(
                [
                    'error' => $weather['error']
                ],
                $weather['message'],
                500
            );
        }


        return $this->sendSuccessResponse($weather['data']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('weather::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('weather::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('weather::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
