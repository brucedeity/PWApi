<?php

namespace App\Service\Packets;

class DataTypes
{
    public static function getWriteMethod(string $dataType): ?string
    {
        $writeMethods = [
            'int' => 'WriteUInt32',
            'octets' => 'WriteOctets',
            'string' => 'WriteUString',
            'byte' => 'WriteUByte'
        ];
    
        return $writeMethods[$dataType] ?? null;
    }
}
