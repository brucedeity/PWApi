<?php

namespace App\Service\Packets;

class WritePacket {
	public $request, $response, $passestablished = false, $getresponse = true;
 
	public function WriteBytes($value){
		$this->request .= $value;
	}
 
	public function WriteUByte($value){
		$this->request .= pack("C", $value);
	}
 
	public function WriteFloat($value){
		$this->request .= strrev(pack("f", $value));
	}
 
	public function WriteUInt32($value){
		$this->request .= pack("N", $value);
	}
 
	public function WriteUInt16($value){
		$this->request .= pack("n", $value);
	}
 
	public function WriteOctets($value){
		if (ctype_xdigit($value))
			$value = pack("H*", $value);
		$this->request .= $this->CUInt(strlen($value));
		$this->request .= $value;
	}
 
	public function WriteUString($value, $coding = "UTF-16LE"){
		$value = iconv("UTF-8", $coding, $value);
		$this->request .= $this->CUInt(strlen($value));
		$this->request .= $value;
	}
 
	public function Pack($value){
		$this->request = $this->CUInt($value) . $this->CUInt(strlen($this->request)) . $this->request;
	}
 
	public function Unmarshal(){
		return $this->CUInt(strlen($this->request)) . $this->request;
	}
 
	public function Send($address, $port){
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
 
		if (socket_connect($socket, $address, $port)) {
			socket_set_block($socket);
 
			if ($this->passestablished)
				socket_recv($socket, $trash, 1024, 0);
 
			$send = socket_send($socket, $this->request, 131072, 0);
 
			if ($this->getresponse)
				$recv = socket_recv($socket, $this->response, 131072, 0);
 
			socket_set_nonblock($socket);
			socket_close($socket);
 
			return true;
		} else return false;
	}
 
	public function WriteCUInt32($value){
		$this->request .= $this->CUInt($value);
	}
 
	private function CUInt($value){
		if ($value <= 0x7F)
			return pack("C", $value);
		else if ($value <= 0x3FFF)
			return pack("n", ($value | 0x8000));
		else if ($value <= 0x1FFFFFFF)
			return pack("N", ($value | 0xC0000000));
		else
			return pack("C", 0xE0) . pack("N", $value);
	}
}