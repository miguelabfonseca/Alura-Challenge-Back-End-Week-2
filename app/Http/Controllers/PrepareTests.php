<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;

class PrepareTests extends Controller
{
    public function index(): Void
    {
        $client = new Client();

        $response = $client->request('GET', config('app.url') . '/categories');
        File::put(base_path('tests/Feature/json/categorias-schema.json'), $response->getBody());

        $response = $client->request('GET', config('app.url') . '/categories/2/videos');
        File::put(base_path('tests/Feature/json/categoria-videos-schema.json'), $response->getBody());

        $response = $client->request('GET', config('app.url') . '/categories/2');
        File::put(base_path('tests/Feature/json/categoria-2-schema.json'), $response->getBody());

        $response = $client->request('GET', config('app.url') . '/videos');
        File::put(base_path('tests/Feature/json/videos-schema.json'), $response->getBody());

        $response = $client->request('GET', config('app.url') . '/videos/1');
        File::put(base_path('tests/Feature/json/videos-1-schema.json'), $response->getBody());

        $response = $client->request('GET', config('app.url') . '/videos?search=ap');
        File::put(base_path('tests/Feature/json/search-video-schema.json'), $response->getBody());

    }

}
