<?php
/**
 * Created by PhpStorm.
 * User: denny
 * Date: 2019-06-24
 * Time: 14:50
 */


return [
    'rate_limits' => [
        'expires' => [
            'expires' => env('RATE_LIMITS_EXPIRES', 1),
            'limit' => env('RATE_LIMITS', 60),
        ],
        'sign' => [
            'expires' => env('SIGN_RATE_LIMITS_EXPIRES', 1),
            'limit' => env('SIGN_RATE_LIMITS', 10),
        ]
    ],
    'auth' => [
        'jwt' => 'Dingo\Api\Auth\Provider\JWT',
    ],
];
