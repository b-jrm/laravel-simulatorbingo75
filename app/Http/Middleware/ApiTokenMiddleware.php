<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Token;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = Token::where('token',$request->bearerToken())->first();
        
        if(!empty($token))
            $request->merge([ 'user_id' => $token['user_id'] ]);
        
        if( empty($token) || (isset($token['token_id']) && date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($token['expires_at']))  ) ){
            abort(
                response()->json([
                    'message' => 'Access Denied',
                ], 401)
            );
        }
        
        return $next($request);
    }
}
