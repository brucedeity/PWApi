<?php

namespace App;

class Config
{
    private $data;

    public function __construct()
    {
        $this->data = [
            'token' => 'Fvu3ZM7SjYHyXNw5Jyyj59k9S4T',
            'version' => '145',
            'host' => 'localhost',
            'ports' => [
                'gamedbd' => 29400,
                'gdeliveryd' => 29100,
                'glinkd' => 29000,
                'gacd' => 29300,
            ]
        ];
    }

    public function getToken()
    {
        return $this->data['token'];
    }

    public function getVersion()
    {
        return $this->data['version'];
    }

    public function getGdeliverydPort()
    {
        return $this->data['ports']['gdeliveryd'];
    }

    public function getGamedbdPort()
    {
        return $this->data['ports']['gamedbd'];
    }

    public function getGlinkdPort()
    {
        return $this->data['ports']['glinkd'];
    }

    public function getGacdPort()
    {
        return $this->data['ports']['gacd'];
    }

    public function getHost()
    {
        return $this->data['host'];
    }
}