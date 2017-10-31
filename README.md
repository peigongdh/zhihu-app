# Uhihz

Uhihz is a zhihu like forum

## Modules

- core module use [laravel](https://github.com/laravel/laravel)
- front module use [vue](https://github.com/vuejs/vue)
- admin module use [laravel-admin](https://github.com/z-song/laravel-admin)
- timeline module use [zhihu-app-timeline](https://github.com/peigongdh/zhihu-app-timeline)

## install
npm install

```
composer update
npm(cnpm) install
npm(cnpm) run dev
```

migration, need create db first

```
php artisan migrate
```

adm install

```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
php artisan admin:install
```

use sql/laravel-admin.sql

```
mysql > ...
```

## demo

[https://uhihz.peigongdh.com](https://uhihz.peigongdh.com)