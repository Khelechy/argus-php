<?php

namespace Khelechy\Argus;

use Khelechy\Argus\Helpers\Helper;
use Khelechy\Argus\Exceptions\ArgusException;

class Argus{

    private readonly string $username;
    private readonly string $password;
    private readonly string $host;
    private readonly int $port;

    private $socket = null;

    public function __construct($username, $password, $host = '', $port = 0){
        $this->username = $username ?? '';
        $this->password = $password ?? '';
        $this->host = $host ?? '127.0.0.1';
        $this->port = $port == 0 ? 1337 : $port;
    }

    public function connect(){
        try{
            
            $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
            socket_connect($this->socket, $this->host, $this->port);
            
            $this->sendAuthData($this->socket, $this->username, $this->password);

            while(true){
                $data = socket_read($this->socket, 1024);

               if($data !== ''){

                    $isJson = Helper::isJsonString($data);

                    if($isJson){
                        // Return Json decoded Argus Event
                    }else{
                        echo "Received: $data\n";
                    }
               }
    
            }
            
            // Close the connection
            socket_close($this->socket);

        }catch(\Exception $exp){
            socket_close($this->socket);
            throw new ArgusException($exp);
        }
    }

    private function sendAuthData($socket, $username, $password){
        $connectionString = "<ArgusAuth>".$username.":".$password."</ArgusAuth>";
        socket_write($socket, $connectionString);
    }
}