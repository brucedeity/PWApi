<?php

namespace App\Service;

use App\Service\ConfigHandler;

class PacketStructure
{
    private $packetName;

    private $version;

    private $structure;

    public function __construct(string $packetName, string $version)
    {   
        $this->packetName = $packetName;

        $this->version = $version;

        $this->structure = $this->getStructure();
    }

    private function getStructures()
    {
        return require __DIR__  . '/Versions/'. $this->version. '/Structure.php';
    }

    public function getStructure()
    {
        return $this->getStructures()[$this->packetName] ?? [];
    }

    public function getOpcode()
    {
        return $this->structure['info']['opcode'];
    }

    public function getDestination()
    {
        return $this->structure['info']['destination'];
    }
}
