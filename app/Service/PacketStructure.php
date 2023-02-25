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

    public function getDataType()
    {
        return array_diff_key($this->structure, ['info' => true]);
    }

    private function getStructure()
    {
        return require __DIR__  . '/Versions/'. $this->version. '/' . $this->packetName. '.php';
    }

    public function getOpcode()
    {
        return $this->structure['info']['opcode'];
    }

    public function getDestination()
    {
        return $this->structure['info']['destination'];
    }

    public function needsResponse() : bool
    {
        if (!array_key_exists('needs_response', $this->structure)) return false;

        if (!$this->structure['needs_response']) return false;

        return true;
    }
}
