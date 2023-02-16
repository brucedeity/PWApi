<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\RequestHandlerController;

$controller = new RequestHandlerController();
$controller->buildPacket();