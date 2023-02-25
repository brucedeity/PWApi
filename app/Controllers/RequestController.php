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
        if (!$this->request->verifyToken()) return 'The given token is invalid.';

        $packet = $this->request->buildPacketStructure();

        $writePacket = new WritePacket;
        
        foreach ($packet->getDataType() as $key => $value) {
            // echo DataTypes::getWriteMethod($value). ' = '. $this->request->getPacketKey($key). '<br/>';

            // $data[DataTypes::getWriteMethod($value)] = $this->request->getPacketKey($key);

            $writePacket->{DataTypes::getWriteMethod($value)}($this->request->getPacketKey($key));
        }

        $writePacket->Pack($packet->getOpcode());
        $writePacket->Send($this->request->get('host'), $this->request->get('destinationPort'));

        if ($packet->needsResponse()) return $this->readPacket($writePacket);
    }

    public function readPacket(WritePacket $writtenPacket)
    {
        return $writtenPacket;
    }
}