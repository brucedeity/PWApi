<?php

namespace App\Controllers;

use App\Service\Packets\WritePacket;
use App\Service\Packets\DataType;
use App\Service\ConfigHandler;
use App\Service\Versions\VersionHandler;

class RequestController {

    private $config;

    private $opcodeStructure;

    public function __construct()
    {
        $this->config = ConfigHandler::load('Main');

        $this->opcodeStructure = (new VersionHandler($this->config['version']))->getOpcodes();
    }

    public function buildPacket(string $opcode = '', array $params = [])
    {
        $params = [
            'channel' => 1,
            'emotion' => 0,
            'srcroleid' => 0,
            'msg' => 'hello world!',
            'data' => ''
        ];

        $packet = new WritePacket;
        
        foreach ($this->getPacketStructure($params) as $key => $value) {
            $packet->{$key}($value);
        }


    }

    public function getPacketStructure(array $params)
    {
        $dataType = new DataType;
        return $dataType->build($params);
    }
}