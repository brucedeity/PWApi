<?php

namespace App\Service\Packets;

class ReadPacket {
	public $data, $pos;
 
	function __construct($obj = null){
		$this->data = $obj->response;
	}
 
	public function ReadBytes($length){
		$value = substr($this->data, $this->pos, $length);
		$this->pos += $length;
 
		return $value;
	}
 
	public function ReadUByte(){
		$value = unpack("C", substr($this->data, $this->pos, 1));
		$this->pos++;
 
		return $value[1];
	}
 
	public function ReadFloat(){
		$value = unpack("f", strrev(substr($this->data, $this->pos, 4)));
		$this->pos += 4;
 
		return $value[1];
	}
 
	public function ReadUInt32(){
		$value = unpack("N", substr($this->data, $this->pos, 4));
		$this->pos += 4;
 
		return $value[1];
	}
 
	public function ReadUInt16(){
		$value = unpack("n", substr($this->data, $this->pos, 2));
		$this->pos += 2;
 
		return $value[1];
	}
 
	public function ReadOctets(){
		$length = $this->ReadCUInt32();
		$value  = unpack("H*", substr($this->data, $this->pos, $length));
		$this->pos += $length;
 
		return $value[1];
	}
 
	public function ReadUString(){
		$length = $this->ReadCUInt32();
 
		$value  = iconv("UTF-16", "UTF-8", substr($this->data, $this->pos, $length)); // LE?
		$this->pos += $length;
 
		return $value;
	}
 
	public function ReadPacketInfo(){
		$packetinfo['Opcode'] = $this->ReadCUInt32();
		$packetinfo['Length'] = $this->ReadCUInt32();
 
		return $packetinfo;
	}
 
	public function Seek($value){
		$this->pos += $value;
	}
 
	public function ReadCUInt32(){
		$value = unpack("C", substr($this->data, $this->pos, 1));
		$value = $value[1];
		$this->pos++;
 
		switch ($value & 0xE0) {
			case 0xE0:
				$value = unpack("N", substr($this->data, $this->pos, 4));
				$value = $value[1];
				$this->pos += 4;
				break;
			case 0xC0:
				$value = unpack("N", substr($this->data, $this->pos - 1, 4));
				$value = $value[1] & 0x1FFFFFFF;
				$this->pos += 3;
				break;
			case 0x80:
			case 0xA0:
				$value = unpack("n", substr($this->data, $this->pos - 1, 2));
				$value = $value[1] & 0x3FFF;
				$this->pos++;
				break;
		}
 
		return $value;
	}
}