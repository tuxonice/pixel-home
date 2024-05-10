<?php

namespace App\Http\Controllers;

use App\Services\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PingController extends Controller
{
    public function push(Request $request)
    {
        $auth = $request->headers->get('Authorization');
        if('Bearer '.env('AUTHORIZATION_TOKEN') === $auth) {
            Cache::put('ping-last', time(), 10);

            return response('Ok', 200);
        }

        return response('Not Found', 404);
    }

    public function pull(Request $request, Mail $mail)
    {

//        dd(Cache::get('ping-last'));

        $response = Http::get('http://example.com');

    }
}
