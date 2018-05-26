<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

/**
 * Class AccessToken
 *
 * @package \App
 */
class AccessToken
{
    protected $accessToken;

    public function __construct()
    {
        $this->init();
    }

    /**
     * 获取 access_token
     *
     * @return mixed
     */
    public function get()
    {
        if (!$this->validate()) {
            $this->refresh();
        }

        return $this->accessToken['access_token'];
    }

    /**
     * 刷新 access_token
     */
    public function refresh()
    {
        $url = sprintf('%s?grant_type=%s&appid=%s&secret=%s',
            config('wxapp.access_token_api'),
            'client_credential',
            config('wxapp.appid'),
            config('wxapp.secret')
        );

        $client = new Client();
        $response = $client->request('GET', $url);
        $res = $response->getBody()->getContents();
        $res = json_decode($res, true);

        $this->accessToken = [
            'access_token' => $res['access_token'],
            'expire_time' => time() + 7000
        ];

        Cache::forever('accessToken', $this->accessToken);
    }

    /**
     * 检查 access_token
     *
     * @return bool
     */
    protected function validate()
    {
        $now = time();

        if (!$this->accessToken) {
            return false;
        } else if ($now > $this->accessToken['expire_time']) {
            return false;
        }

        return true;
    }

    private function init()
    {
        $this->accessToken = Cache::get('accessToken');
    }
}
