<?php

namespace App\Service\Packets;

class DataType
{
    public static function getWriteMethod(string $dataType): ?string
    {
        $writeMethods = [
            'int' => 'WriteUInt32',
            'octets' => 'WriteUInt32',
            'byte' => 'WriteUByte'
        ];
    
        return $writeMethods[$dataType] ?? null;
    }
}
