<?php

namespace App\Controllers;

use App\Service\Packets\WritePacket;
use App\Service\Packets\DataTypes;
use App\Service\ConfigHandler;
use App\Request;
use App\Service\Versions\VersionHandler;

class RequestController {

    private $request;
    private $sendedData;

    public function __construct()
    {
        $this->request = new Request;
    }

    public function buildPacket()
    {
        // return $this->request->verifyToken();
        
        if (!$this->request->verifyToken()) return 'The given token is invalid.';

        $packetStructure = $this->request->buildPacketStructure();

        $writePacket = new WritePacket;
        
        foreach ($packetStructure as $key => $value) {
            echo DataTypes::getWriteMethod($value). ' = '. $this->request->getPacketKey($key). '<br/>';

            $writePacket->{DataTypes::getWriteMethod($value)}($this->request->getPacketKey($key));
        }

        $writePacket->Pack($packetStructure->getOpcode());
        $writePacket->Send($this->request->get('host'), $this->request->get('destinationPort'));
    }
}