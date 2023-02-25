<?php

namespace App\Controllers;

use App\Service\Packets\ReadPacket;
use App\Service\Packets\WritePacket;
use App\Service\Packets\DataTypes;
use App\Service\ConfigHandler;
use App\Request;
use App\Service\PacketStructure;
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

            $keyValue = $this->request->getPacketKey($key);

            $dataType = new DataTypes();
            $dataType->setKey($key);
            $dataType->setValue($value);
            $dataType->setKeyValue($value);

            $method = $dataType->getWriteMethod();

            $writePacket->{$method}($keyValue);
        }

        $writePacket->Pack($packet->getOpcode());
        $writePacket->Send($this->request->get('host'), $this->request->get('destinationPort'));

        if ($packet->needsResponse()) {
            return $this->readPacket($writePacket, $packet->getResponsePacketName());
        }
    }

    public function readPacket(WritePacket $writtenPacket, string $responsePacketName)
    {
        $readPacket = new ReadPacket($writtenPacket);

        $responsePacket = new PacketStructure($responsePacketName, $this->request->get('version'));

        // return $responsePacket->getDataType();

        $readedValues = [];

        
        foreach ($responsePacket->getDataType() as $key => $value) {
            
            $dataType = new DataTypes();
            // if ($iteration > 2) continue;

            // $keyValue = $this->request->getPacketKey($key);

            // return $value;

            $dataType->setKey($key);
            $dataType->setValue($value);
            // $method = $dataType->getWriteMethod();

            // if (!is_array($value)) continue;

            // return $dataType->getReadMethod();

            // $writePacket->{$method}($keyValue);

            if (!$dataType->needsReadWrite()) continue;

            $method = $dataType->getReadMethod();

            // $response[] = $dataType->getReadedValue();

            $response[] = $method;

            // $response[] = $readPacket->{$dataType->getReadedValue()}();  
        }

        return $response;
    }

    public function getFinalValues($array) {
        $result = array();
    
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $subArray = $this->getFinalValues($value);
                $result = array_merge($result, $subArray);
            } else {
                $result[] = $value;
            }
        }
    
        return $result;
    }
    
    
    
}