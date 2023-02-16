<?php

namespace App\Service\Packets;

class DataType
{
    public function build(array $params) : array
    {
        $data = [];

        foreach ($params as $key => $value) {
            $this->getRespectiveMethod()
        }

        return $data;
    }

    private function getRespectiveMethod(string $key)
    {
        $types = [
            'int' => 'WriteUInt32',
            'octets' => 'WriteUInt32',
            'byte' => 'WriteUByte'
        ];

        return $types[$key] ?? NULL;
    }
}
