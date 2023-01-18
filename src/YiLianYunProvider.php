<?php

namespace Woody\YiLianYun;

use Illuminate\Support\ServiceProvider;

class YiLianYunProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/yilianyun.php' => config_path('yilianyun.php'), // 发布到 laravel config 下
        ]);
    }
}
