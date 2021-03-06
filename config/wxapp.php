<?php

return [
    'appid' => env('WX_APPID', 'appid'),

    'secret' => env('WX_SECRET', 'secret'),

    'grant_type' => 'authorization_code',

    // api
    'user_info_url' => 'https://api.weixin.qq.com/sns/jscode2session',

    'access_token_api' => 'https://api.weixin.qq.com/cgi-bin/token',

    'msg_sec_check' => 'https://api.weixin.qq.com/wxa/msg_sec_check'
];
