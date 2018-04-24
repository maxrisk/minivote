<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\WXCrypt\WXBizDataCrypt;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'token']]);
    }

    /**
     * 获取 token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function token(Request $request)
    {
        $code = $request->get('code');
        $encryptedData = $request->get('encryptedData');
        $iv = $request->get('iv');

        // 1. code2session
        $res = $this->code2session($code);
        $res = [
            'session_key' => "2JAuuT1DLPtOMTKsQQbHzw==",
            "openid" => "oA1g95ZvRJ6qSpsXVDfEYTUej1f0"
        ];
        if (isset($res['errcode'])) {
            return json_encode($res);
        }

        $user = User::where('openid', $res['openid'])->first();

        // 2. 解密获取用户数据
        $sessionKey = $res['session_key'];
        $pc = new WXBizDataCrypt(config('wxapp.appid'), $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);

        if ($errCode == 0) {
            if (isset($res['openid'])) {
                $user = $this->findUserOrCreate(json_decode($data, true));
                $token = auth()->login($user);

                return $this->responseWithToken($token);
            }
        } elseif ($user != null) {   // 解决 errCode = 41003 的问题
            $token = auth()->login($user);

            return $this->responseWithToken($token);
        }

        return response()->json(['errCode' => $errCode]);
    }

    public function responseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * code2session
     *
     * @param string $code
     * @return bool/array
     */
    private function code2session($code)
    {
        $client = new Client([
            'timeout' => 10.0,
        ]);

        $url = sprintf('%s?appid=%s&secret=%s&js_code=%s&grant_type=%s',
            config('wxapp.user_info_url'),
            config('wxapp.appid'),
            config('wxapp.secret'),
            $code,
            config('wxapp.grant_type')
        );
        $response = $client->get($url);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 检查用户是否存在，不存在则创建之
     *
     * @param array $userInfo
     * @return mixed
     */
    private function findUserOrCreate($userInfo)
    {
        $user = User::where('openid', $userInfo['openId'])->first();

        if (is_null($user)) {
            $user = $this->createUser($userInfo);
        } else {
            $user->openid = $userInfo['openId'];
            $user->nick_name = $userInfo['nickName'];
            $user->avatar_url = $userInfo['avatarUrl'];
            $user->gender = $userInfo['gender'];
            $user->city = $userInfo['city'];
            $user->province = $userInfo['province'];
            $user->country = $userInfo['country'];
            $user->language = $userInfo['language'];
        }

        return $user;
    }

    private function createUser($user)
    {
        return User::create([
            'openid' => $user['openId'],
            'nick_name' => $user['nickName'],
            'avatar_url' => $user['avatarUrl'],
            'gender' => $user['gender'],
            'city' => $user['city'],
            'province' => $user['province'],
            'country' => $user['country'],
            'language' => $user['language'],
        ]);
    }
}
