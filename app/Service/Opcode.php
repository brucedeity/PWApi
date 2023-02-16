<?php

namespace App\Service;

use App\Service\ConfigHandler;

class Opcode
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

    private function getOpcodes()
    {
        return __DIR__  . '/Versions/'. $this->version. '/Opcodes.php';
    }

    public function getStructures()
    {
        return require __DIR__  . '/Versions/'. $this->version. '/Structure.php';
    }

    public function getStructure()
    {
        return $this->getStructures()[$this->packetName] ?? [];
    }

    public function getOpcodeHex()
    {
        return $this->getOpcodes()[$this->packetName] ?? 0;
    }

    public function getDestination()
    {
        return $this->structure['destination'];
    }
}
