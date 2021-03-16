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
       $categories = Cache::get('CATEGORIES');

        if (empty($categories) === false) {
            $categoriesSanitized = $this->sanitize($categories);
            return response()->json($categoriesSanitized);
        }

        $response = $this->http->get('V1/categories')->json();
        Cache::put('CATEGORIES', $response, 3600);

        return response()->json($response);
    }

    public function sanitize(array $categories): array
    {
        if (array_key_exists('level', $categories)) {
            unset($categories['level']);
        }

        if (array_key_exists('is_active', $categories)) {
            unset($categories['is_active']);
        }

        if (count($categories['children_data']) > 0) {
            foreach ($categories['children_data'] as $category) {
                $this->sanitize($category);
            }
        }

        return $categories;
    }


    public function products(Request $request): JsonResponse
    {
        $response = $this->http->get('V1/products', $request->all())->json();
        return response()->json($response);
    }
}
