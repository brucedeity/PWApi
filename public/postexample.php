<?php

$data = [
    'token' => 'Fvu3ZM7SjYHyXNw5Jyyj59k9S4T',
    'server' => [
        'version' => '145',
        'host' => 'localhost',
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
            'msg' => 'hello world!',
            'data' => ''
        ]
    ]
];

// Create a URL-encoded query string from the data
$dataString = http_build_query($data);

// Set up the cURL request
$ch = curl_init("http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FAILONERROR, true);

// Send the request and retrieve the response
$response = curl_exec($ch);

// Check for cURL errors
if(curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Check HTTP status code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpCode >= 400) {
    echo "Error: Received HTTP status code $httpCode";
}

// Print the response
print_r($response);

// Close the cURL session
curl_close($ch);
