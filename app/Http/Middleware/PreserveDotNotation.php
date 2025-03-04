<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Response;

class PreserveDotNotation
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the query string without PHP modifying it
        $queryString = $request->server->get('QUERY_STRING');

        // Manually parse parameters
        $originalQueryParams = [];
        parse_str($queryString, $tempParams);

        foreach (explode('&', $queryString) as $param) {
            $pair = explode('=', $param, 2);
            if (count($pair) === 2) {
                $originalQueryParams[urldecode($pair[0])] = urldecode($pair[1]);
            }
        }

        // Replace the Laravel query with the original
        $request->query = new InputBag($originalQueryParams);

        return $next($request);
    }
}
