# yilianyun-laravel-sdk
易联云 laravel 专用 SDK

使用：

1. 配置文件生成
```shell
php artisan vendor:publish # 选择对应的扩展包
```

2. `.env` 文件增加配置
```text
YILIANYUN_HOST=xxx
YILINAYUN_CLIENT_ID=xxxx
YILIANYUN_CLIENT_SECRET=xxxx
```
3. 打印内容处理
    * 实现接口 `ContentContract`
    * 通过 `generateContent()` 方法生成打印的内容，内容模版参考 [打印机指令](https://www.kancloud.cn/elind-dev/openapi/332006)