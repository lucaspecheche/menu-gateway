<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TestsController
{
    protected PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::baseUrl('https://menu.com.br/rest/default/')
            ->withToken(env('M2_TOKEN'));
    }

    public function categories(): JsonResponse
    {
        if ($categories = Cache::get('CATEGORIES')) {
            return response()->json($categories);
        }

        $response = $this->http->get('V1/categories')->json();
        Cache::put('CATEGORIES', $response, 3600);

        return response()->json($response);
    }

    public function products(Request $request): JsonResponse
    {
        $response = $this->http->get('V1/products', $request->all())->json();
        return response()->json($response);
    }
}
