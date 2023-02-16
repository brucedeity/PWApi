<?php

namespace App\Controllers;

use App\Service\Packets\WritePacket;
use App\Service\Packets\DataType;
use App\Service\ConfigHandler;
use App\Service\Opcode;
use App\Service\Versions\VersionHandler;

class RequestController {

    private $request;

    public function __construct()
    {   
        $this->request = [
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
                'channel' => 1,
                'emotion' => 0,
                'srcroleid' => 0,
                'msg' => 'hello world!',
                'data' => ''
            ]
        ];
    }

    public function buildPacket(string $packetName = '', array $params = [])
    {
        $opcode = new Opcode($packetName, $params['server']['version']);

        $packet = new WritePacket;
        
        foreach ($opcode->getStructure() as $key => $value) {
            $packet->{DataType::getWriteMethod($value)}($this->getRequestValue($key));
        }

        $packet->Pack($opcode->getOpcodeHex());
        $packet->Send($this->getRequestValue('server')['host'], $this->getPort($opcode->getDestination()));
    }

    public function getRequestValue(string $key)
    {
        return $this->request[$key] ?? NULL;
    }

    public function getPort(string $proccess)
    {
        $this->request['server']['ports'][$proccess];
    }
}