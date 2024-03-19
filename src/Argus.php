<?php

namespace Khelechy\Argus;

class Argus{

    private readonly string username;
    private readonly string password;
    private readonly string host;
    private readonly int port;

    private $socket

    public function __construct(){
        $this->username = ""
        $this->password = ""
        $this->host = ""
        $this->port
    }

    public function connect(){
        try{
            
            $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
            socket_connect($socket, $host, $port);
            
            sendAuthData($socket, $this->username, $this->password)

            $data = socket_read($socket, 1024);

            echo "Received: $data\n";

            // Close the connection
            socket_close($this->socket);

        }catch(){
            socket_close($socket);
        }
    }

    private function sendAuthData($socket, $username, $password){
        $connectionString = "<ArgusAuth>".$username.":".$password."</ArgusAuth>"
        socket_write($socket, $connectionString);
    }
}