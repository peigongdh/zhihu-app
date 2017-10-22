# Uhihz-A zhihu like forum

## install

安装依赖

```
composer update
npm(cnpm) install
npm(cnpm) run dev
```


安装应用数据库

```
php artisan migrate
```

安装admin（可能需要修复冲突）


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

手动执行sql/laravel-admin.sql


```
mysql > ...
```

## demo

[https://uhihz.peigongdh.com](https://uhihz.peigongdh.com)