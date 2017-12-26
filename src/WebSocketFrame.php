<?php
namespace aiwhj\swooleWsClient;

class WebSocketFrame {
	public $finish = false;
	public $opcode;
	public $data;
	public $length;
	public $rsv1;
	public $rsv2;
	public $rsv3;
	public $mask;
}