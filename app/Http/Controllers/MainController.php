<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function pogoda(Request $request){
        $client = new Client();
        $result = $client->request('get', 'http://api.openweathermap.org/data/2.5/forecast?lat=53.2968804&lon=34.2312728&appid=df6c7d1d86eddbf41b64d5b504f9aa75');
        $data = json_decode($result->getBody()->getContents(), true);
        return view('main', [
            'temp' => $data['list'][0]['main']['temp'] - 273,
            'template' => 'pogoda_v_brianske'
        ]);
    }

}
