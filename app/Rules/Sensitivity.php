<?php

namespace App\Rules;

use App\AccessToken;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class Sensitivity implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->msgSecCheck($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '内容存在敏感词';
    }

    private function msgSecCheck($content)
    {
        if (empty($content)) {
            return true;
        }

        $url = sprintf('%s?access_token=%s',
            config('wxapp.msg_sec_check'),
            (new AccessToken())->get()
        );

        $json = exec('curl -d \'{ "content":"'. $content .'" }\' \'' . $url . '\'');

//        $client = new Client();
//        $response = $client->request('POST', $url, [
//            'body' => json_encode(['content' => $content]),
//            'headers' => [
//                'Content-Type' => 'application/json',
//            ]
//        ]);
//        $json = $response->getBody()->getContents();

        $res = json_decode($json, true);

        if ($res['errcode'] != 0) {
            return false;
        }

        return true;
    }
}
