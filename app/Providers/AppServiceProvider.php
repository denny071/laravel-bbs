<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            //注册SudoSu插件
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
        \API::error(function(\Illuminate\Database\Eloquent\ModelNotFoundException $exception){
            abort(404);
        });
        \API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, $exception->getMessage());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
	    // 注册用户观察者
		\App\Models\User::observe(\App\Observers\UserObserver::class);

		// 注册回复观察者
		\App\Models\Reply::observe(\App\Observers\ReplyObserver::class);

		// 注册主题观察者
		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);

		// 注册链接观察者
		\App\Models\Link::observe(\App\Observers\LinkObserver::class);

		//设置Carbon对象显示时间为中文
        \Carbon\Carbon::setLocale("zh");


    }
}
