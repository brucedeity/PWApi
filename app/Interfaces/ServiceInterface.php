<?php

namespace App\Interfaces;

interface ServiceInterface {
    public function buildPacket();

    public function getOpcode();
}