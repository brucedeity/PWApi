<?php

namespace App\Service\Versions;

class VersionHandler
{
    private $version;
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    public function getOpcodes()
    {
        return __DIR__  . '/'. $this->version. '/Opcodes.php';
    }

    public function getStructure()
    {
        return __DIR__  . '/'. $this->version. '/Structure.php';
    }
}
