<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/12
 * Time: 22:27
 */

if (! function_exists('user')) {
    function user($driver = null) {
        if ($driver) {
            return app('auth')->guard($driver)->user();
        }
        return app('auth')->user();
    }
}