<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    //全局中间件
    protected $middleware = [

        // 加测是否应用进入【维护模式】
        \App\Http\Middleware\CheckForMaintenanceMode::class,

        // 检测表单请求的数据是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // 对提交的请求参数进行php函数`trim()`处理
        \App\Http\Middleware\TrimStrings::class,

        // 将提交请求参数中空字符串转换为 null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        // 修正代理服务器后的服务器参数
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [

        // Web 中间件组，应用于routes/web.php 路由文件 在RouteServiceProvider 中设定
        'web' => [

            // Cookie 加密解密
            \App\Http\Middleware\EncryptCookies::class,

            // 将Cookie 添加到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // 开启会话
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,

            // 将系统的错误数据植入到视图变量 $errors 中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // 简餐CSRF,防止跨站请求伪造的安全威胁
            \App\Http\Middleware\VerifyCsrfToken::class,

            // 处理路由绑定
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // 前瞻用户邮箱认证
            \App\Http\Middleware\EnsureEmailIsVerified::class,

            // 记录用户最后活跃时间
            \App\Http\Middleware\RecordLastActivedTime::class

        ],
        // API 中间件组，应用于 routes/api.php 路由文件
        // 在routeServiceProvider中设定
        'api' => [
            //使用别名调用中间件
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    // 中间件别名设置，允许你使用别名调用中间件，例如上面api中间件组调用
    protected $routeMiddleware = [

        // 只有登录用户才能访问，我们在控制器的构造方法中大连使用
        'auth' => \App\Http\Middleware\Authenticate::class,

        // HTTP Baseic Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // 处理路由绑定
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // 用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // 只有游客才能访问，在register 和login 请求中使用，只有未登录用户才能访问这些页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // 签名认证。在找回密码中用过
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // 访问节流， 类似于 【1分钟只能请求10次】的需求，一般在API中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Laravel 自带的强制用户邮箱认证的中间件
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */

    // 设定中间件优先级，次数组定义了除【全局中间件】意外的中间件执行程序
    // 可以看到 StartSession 永远是开始执行的，因为 StartSession 后，
    // 我们才能在程序中使用 Auth 等用户认证的功能
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
