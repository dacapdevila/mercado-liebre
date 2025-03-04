<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = User::query();

        // Filters JSON:API
        if ($request->has('filter.name')) {
            $query->where('name', 'like', '%' . $request->query('filter.name') . '%');
        }
        if ($request->has('filter.email')) {
            $query->where('email', 'like', '%' . $request->query('filter.email') . '%');
        }

        // Pagination
        $users = $query->paginate($request->query('page.size', 10));

        return response()->json([
            'data' => $users->map(fn ($user) => [
                'type' => 'users',
                'id' => (string) $user->id,
                'attributes' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->toISOString(),
                ],
                'links' => [
                    'self' => route('api.users.show', $user->id),
                ]
            ]),
            'meta' => [
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'last_page' => $users->lastPage(),
            ],
            'links' => [
                'self' => $users->url($users->currentPage()),
                'next' => $users->nextPageUrl(),
                'prev' => $users->previousPageUrl(),
            ],
        ], 200);
    }

    public function show()
    {
        // TODO: add request single resource
    }
}
