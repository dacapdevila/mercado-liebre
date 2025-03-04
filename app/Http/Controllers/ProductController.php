<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // Filters JSON:API
        if ($request->has('filter.name')) {
            $query->where('name', 'like', '%' . $request->query('filter.name') . '%');
        }
        if ($request->has('filter.price_min')) {
            $query->where('price', '>=', $request->query('filter.price_min'));
        }
        if ($request->has('filter.price_max')) {
            $query->where('price', '<=', $request->query('filter.price_max'));
        }

        // Pagination
        $products = $query->paginate($request->query('page.size', 10));

        return response()->json([
            'data' => $products->map(fn ($product) => [
                'type' => 'products',
                'id' => (string) $product->id,
                'attributes' => [
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'created_at' => $product->created_at->toISOString(),
                ],
            ]),
            'meta' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ],
            'links' => [
                'self' => $products->url($products->currentPage()),
                'next' => $products->nextPageUrl(),
                'prev' => $products->previousPageUrl(),
            ],
        ], 200);
    }
}
