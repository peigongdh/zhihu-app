<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/10/18
 * Time: 1:24
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GatewayClient\Gateway;

class BindController extends Controller
{

    /**
     * BindController constructor.
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    public function bind()
    {
        Gateway::$registerAddress = '127.0.0.1:1236';
    }
}