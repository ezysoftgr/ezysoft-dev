<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('api_key', $request->header('api_key'))->first();
        if ($user){
            return $next($request);
        }
        $response = [
            'status' => 0,
            'message' => "Unauthorized",
            'action'  => 'unauthorized',
            'id' 	  => 0,
            'type'    => 'unauthorized'
        ];

        return  response()->json($response);
    }
}
