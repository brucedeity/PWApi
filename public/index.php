<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\RequestController;

$controller = new RequestController();
$response = $controller->buildPacket('ChatBroadCast', [
        'server' => [
            'version' => '145',
            'host' => '127.0.0.1',
            'ports' => [
                'gamedbd' => 29400,
                'gdeliveryd' => 29100,
                'glinkd' => 29000,
                'gacd' => 29300,
            ]
        ],
        'packet' => [
            'channel' => 1,
            'emotion' => 0,
            'srcroleid' => 0,
            'msg' => 'hello world2222222!',
            'data' => ''
        ]
]);

print_r($response);