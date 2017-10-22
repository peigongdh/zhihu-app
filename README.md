# Uhihz - A zhihu like forum

## install
安装应用数据库

```
php artisan migrate
```

安装admin

```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"

php artisan admin:install
```

安装admin扩展（视需要安装）

```
composer require laravel-admin-ext/helpers

php artisan admin:import helpers

composer require laravel-admin-ext/log-viewer -vvv

php artisan admin:import log-viewer

composer require laravel-admin-ext/scheduling

php artisan admin:import scheduling
```

## demo

[https://uhihz.peigongdh.com](https://uhihz.peigongdh.com)

