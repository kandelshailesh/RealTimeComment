<?php
use Ratchet\Server\IoServer;
use MyApp\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

    // require '../vendor/autoload.php';
require_once 'C:\wamp64\www\Simple\vendor\autoload.php'; 

    $server = IoServer::factory(
        new HttpServer(new WsServer(new Chat())),
        9080
    );

    $server->run();
    ?>