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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BindController extends Controller
{

    /**
     * BindController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function bind(Request $request)
    {
        $clientId = $request->get('client_id');
        if (!$clientId) {
            return response(['status' => 'failed']);
        }
        Gateway::$registerAddress = '127.0.0.1:11110';
        Gateway::bindUid($clientId, Auth::id());
        // Gateway::sendToUid(Auth::id(), json_encode(["hello"]));
        return response(['status' => 'success']);
    }
}
