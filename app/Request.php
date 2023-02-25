<?php

namespace App;

use App\Config;
use App\Service\PacketStructure;

class Request
{
    private $packet;

    private $request;

    private $config;

    public function __construct()
    {
        $this->request = $this->getRequest();

        $this->packet = $this->buildPacketStructure();

        $this->config = new Config;
    }

    public function get(string $key)
    {
        $method = 'get'.$key;

        return $this->{$method}() ?? $this->config->{$method}();
    }

    public function getHost()
    {
        return $this->request['server']['host'];
    }

    public function getVersion()
    {
        return $this->request['server']['version'];
    }

    public function getPacketName()
    {
        return $this->request['packet']['name'];
    }

    public function getPacketDestination()
    {
        return $this->getPacketData();
    }

    public function getServerPorts()
    {
        return $this->request['server']['ports'];
    }

    public function getPacketData()
    {
        return $this->request['packet']['data'];
    }

    public function getPacketKey(string $key)
    {
        return $this->getPacketData()[$key] ?? NULL;
    }

    public function getRequest()
    {
        return empty($_GET) ? $_POST : $_GET;
    }

    public function getPacketResponseName()
    {
        return substr_replace($this->getPacketName(), 'Res', -3);
    }

    public function buildPacketStructure()
    {
        $this->packet = new PacketStructure($this->getPacketName(), $this->get('version'));

        return $this->packet;
    }

    public function getPort(string $destination) : int
    {
        return $this->getServerPorts()[$destination] ?? 0;
    }

    public function getDestinationPort()
    {
        return $this->getPort($this->packet->getDestination());;
    }

    public function verifyToken()
    {
        return $this->request['token'] == $this->config->getToken();
    }
}
