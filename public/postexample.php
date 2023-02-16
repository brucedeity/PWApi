<?php

$data = [
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
        'name' => 'ChatBroadCast',
        'data' => [
            'channel' => 1,
            'emotion' => 0,
            'srcroleid' => 0,
            'msg' => 'hello world2222222!',
            'data' => ''
        ]
    ]
];

// Create a URL-encoded query string from the data
$dataString = http_build_query($data);

// Set up the cURL request
$ch = curl_init('http://192.168.56.101/PWApi/public/');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Send the request and retrieve the response
$response = curl_exec($ch);

// Print the response
echo $response;

// Close the cURL session
curl_close($ch);
