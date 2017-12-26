# swoole_websocket_client
 web 调用 swoole 的 websocket 服务器客户端(composer 版) 

**fork [https://github.com/gy36/swoole_websocket_client](https://github.com/gy36/swoole_websocket_client) **

## 1. 安装
需要安装 [swoole](https://www.swoole.com/) 拓展
```
composer require aiwhj/swoole-websocket-client
```
## 2.服务端
基于 `swoole_websocket_server` 接口实现 `websocket` 服务
```php
<?php

$server = new swoole_websocket_server("0.0.0.0", 2345);

$server->on('open', function (swoole_websocket_server $server, $request) {
	echo "server: handshake success with fd{$request->fd}\n";
});

$server->on('message', function (swoole_websocket_server $server, $frame) {
	echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
	$server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
	echo "client {$fd} closed\n";
});

$server->start();
```
### 3. 客户端
```php
<?php
namespace aiwhj\swooleWsClient;

require 'autoload.php';

$client = new WebSocket('127.0.0.1', 2345, '/VH4OKgcjVHZTPlFzBnVTYwExCS9RdFdwDX5VdwFiV3ADaFRjBio=');

echo '准备' . "<br>";

if (!($temp = $client->connect())) {
	var_dump($temp);
	echo "失败" . "<br>";
	echo "connect to server failed.\n";
	exit;
}
$message = json_encode(array('data' => '这是广播消息', 'to' => [1, 2, 3, 4, 5, 6, 7, 8, 9]), JSON_UNESCAPED_UNICODE);

$client->send($message);
$message = $client->recv();
echo '发送' . "<br>";
if ($message === false) {
	exit;
}
echo "Received from server: {$message}\n";

echo "Closed by server.\n";
```