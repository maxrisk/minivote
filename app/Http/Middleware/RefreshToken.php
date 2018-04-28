<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken();
            $token = JWTAuth::getToken();
        } catch (JWTException $e) {
            abort(401, 'Token missing or badly formatted');
        }

        // 验证 token
        try {
            // If sucessful, save user on request
            $request->user = JWTAuth::authenticate($token);
        } catch (TokenExpiredException $e) {
            try {
                // 尝试刷新 token
                $token = JWTAuth::refresh($token);
                JWTAuth::setToken($token);
                $request->user = JWTAuth::authenticate($token);

                // 在头部返回新的 token
                return $this->setAuthenticationHeader($next($request), $token);
            } catch (TokenExpiredException $e) {
                // Return 401 status
                abort(401, 'Token Expired');
            }
        }

        return $next($request);
    }
}
