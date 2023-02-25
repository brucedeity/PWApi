<?php

namespace App\Service\Packets;

class DataTypes
{
    private $key;
    private $value;
    private $keyValue;
    private $needsReadWrite;
    private $readedValue;

    public function __construct()
    {
        $this->needsReadWrite = true;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setKeyValue($keyValue)
    {
        $this->keyValue = $keyValue;
    }

    public function getWriteMethod()
    {
        // return $this->value;

        if (is_array($this->key)) {
            $result = [];
            foreach ($this->key as $key => $value) {
                $result[$key] = $this->getWriteMethod();
            }
            return $result;
        }

        $writeMethods = [
            'int' => 'WriteUInt32',
            'octets' => 'WriteOctets',
            'string' => 'WriteUString',
            'byte' => 'WriteUByte'
        ];
    
        return $writeMethods[$this->value] ?? null;
    }

    public function getReadMethod()
    {
        // return $this->key;

        if (is_array($this->value)) {
            // return $this->value;
            $result = [];
            foreach ($this->value as $key => $value) {
                $this->setKey($key);
                $this->setValue($value);

                $result[$key] = $this->getReadMethod();
            }
            return $result;
        }
    
        $ReadMethods = [
            'int' => 'ReadUInt32',
            'octets' => 'ReadOctets',
            'string' => 'ReadUString',
            'byte' => 'ReadUByte',
            'cuint' => 'ReadCUInt32',
            'float' => 'ReadFloat',
            'name' => $this->getName(),
            'short' => 'ReadUInt32'
        ];

        $value = $ReadMethods[$this->value] ?? null;

        $this->readedValue = $value;
    
        return $value;
    }

    public function getReadedValue()
    {
        return $this->readedValue;
    }

    public function needsReadWrite()
    {
        return $this->needsReadWrite;
    }

    public function getName()
    {
        $this->needsReadWrite = false;

        return 'ReadUString';
    }
    
}
