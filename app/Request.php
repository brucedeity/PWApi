<?php

namespace App;

use App\Config;
use App\Service\Opcode;

class Request
{
    private $requestType;
    private $opcode;

    public function __construct()
    {
        $this->request = $this->getRequest();

        $this->opcode = $this->buildOpcode();
    }

    public function get(string $key)
    {
        $data = $this->request[$key] ?? NULL;

        return !is_null($data) ? $data : (new Config)->{'get'.$key}();
    }

    public function getPacketName()
    {
        return $this->request['packet']['name'];
    }

    public function getPacketData()
    {
        return $this->request['packet']['data'];
    }

    public function getPacketKey(string $key)
    {
        return $this->getPacketData()[$key] ?? NULL;
    }

    private function getRequest()
    {
        return empty($_GET) ? $_POST : $_GET;
    }

    private function buildOpcode()
    {
        return new Opcode($this->getPacketName(), $this->get('version'));
    }

    public function getOpcode()
    {
        return $this->opcode;
    }
}
