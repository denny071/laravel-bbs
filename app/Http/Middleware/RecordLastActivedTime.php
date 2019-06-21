<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * 自定义中间件，用于记录用户活动时间
 *
 * Class RecordLastActivedTime
 * @package App\Http\Middleware
 */
class RecordLastActivedTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果是登录用户的话
        if (Auth::check()) {
            // 记录最后登录时间
            Auth::user()->recordLastActivedAt();
        }

        return $next($request);
    }
}
