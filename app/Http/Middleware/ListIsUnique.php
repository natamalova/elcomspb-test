<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ListIsUnique
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'items' => 'required|array|min:5',
            'items.*.item' => 'required|unique:items|max:255',
        ]);

        return $next($request);
    }
}
