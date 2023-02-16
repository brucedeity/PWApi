<?php

namespace App\Controllers;

use App\Service\Packets\WritePacket;
use App\Service\Packets\DataTypes;
use App\Service\ConfigHandler;
use App\Service\Opcode;
use App\Service\Versions\VersionHandler;

class RequestController {

    public function buildPacket(string $packetName, array $params = [])
    {
        $opcode = new Opcode($packetName, $params['server']['version']);

        $packet = new WritePacket;
        
        foreach ($opcode->getStructure() as $key => $value) {
            // echo $this->getWriteMethod($value). ' = '. $this->getRequestValue($key). '<br/>';

            $packet->{DataTypes::getWriteMethod($value)}($params['packet'][$key]);
        }

        $packet->Pack(0x78);
        $packet->Send('127.0.0.1', 29300);
    }
}