<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/9/30
 * Time: 0:15
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected $userRepository;

    /**
     * AuthController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('api');
        $this->userRepository = $userRepository;
    }

    /**
     * Auth for skynet-todpole, https://github.com/peigongDH/skynet-mud.git
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function auth(Request $request)
    {
        $status = 'failed';
        $userInfo = '';

        if ($request->get('platform') == 'skynet_mud') {
            $token = $request->get('token');
            $tokenArray = explode("\t", $token);
            if ($tokenArray) {
                $email = $tokenArray[0];
                $password = $tokenArray[1];
            } else {
                return response(['status' => $status, 'data' => $userInfo]);
            }

            if (Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => 1])) {
                // Authentication passed...
                $status = 'success';
                $userInfo = $this->userRepository->getUserInfoForThirdParty(Auth::id());
            }
        }
        
        return response(['status' => $status, 'data' => $userInfo]);
    }

}