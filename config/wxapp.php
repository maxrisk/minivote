<?php

return [
    'appid' => env('WX_APPID', 'appid'),

    'secret' => env('WX_SECRET', 'secret'),

    'grant_type' => 'authorization_code',

    // api
    'user_info_url' => 'https://api.weixin.qq.com/sns/jscode2session'
];
