<?php

namespace App\Controllers;

use App\Service\Packets\WritePacket;
use App\Service\Packets\DataTypes;
use App\Service\ConfigHandler;
use App\Request;
use App\Service\Versions\VersionHandler;

class RequestController {

    public function buildPacket()
    {
        $request = new Request;
        
        $packet = new WritePacket;
        
        foreach ($request->getOpcode()->getStructure() as $key => $value) {
            // echo DataTypes::getWriteMethod($value). ' = '. $request->getPacketKey($key). '<br/>';

            $packet->{DataTypes::getWriteMethod($value)}($request->getPacketKey($key));
        }

        $packet->Pack(0x78);
        $packet->Send('127.0.0.1', 29300);
    }
}