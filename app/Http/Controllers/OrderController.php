<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Order::query();

        // Filters JSON:API
        if ($request->has('filter.status')) {
            $query->where('status', $request->query('filter.status'));
        }
        if ($request->has('filter.user_id')) {
            $query->where('user_id', $request->query('filter.user_id'));
        }

        // Pagination
        $orders = $query->paginate($request->query('page.size', 10));

        return response()->json([
            'data' => $orders->map(fn ($order) => [
                'type' => 'orders',
                'id' => (string) $order->id,
                'attributes' => [
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'created_at' => $order->created_at->toISOString(),
                ],
                'relationships' => [
                    'user' => [
                        'data' => [
                            'type' => 'users',
                            'id' => (string) $order->user_id,
                        ],
                    ],
                ],
            ]),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'last_page' => $orders->lastPage(),
            ],
            'links' => [
                'self' => $orders->url($orders->currentPage()),
                'next' => $orders->nextPageUrl(),
                'prev' => $orders->previousPageUrl(),
            ],
        ], 200);
    }
}
