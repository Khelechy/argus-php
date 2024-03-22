<?php

namespace Khelechy\Argus;

use Khelechy\Argus\Helpers\Helper;
use Khelechy\Argus\Models\ArgusEvent;
use Khelechy\Argus\Exceptions\ArgusException;
use Khelechy\Argus\Handlers\EventBus;

class Argus{

    private readonly string $username;
    private readonly string $password;
    private readonly string $host;
    private readonly int $port;

    private $eventBus;

    private ?\Socket $socket = null;


    public function __construct($username = '', $password = '', $host = '', $port = 0){
        $this->username = $username ?? '';
        $this->password = $password ?? '';
        $this->host = $host == '' ? '127.0.0.1' : $host;
        $this->port = $port == 0 ? 1337 : $port;

        $this-> eventBus = new EventBus();
    }

    public function connect(){
        try{
            
            $this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
            socket_connect($this->socket, $this->host, $this->port) or die("Could not connect to server\n");
            
            $this->sendAuthData($this->socket, $this->username, $this->password);

            while(true){
               $data = socket_read($this->socket, 1024) or die("Connection dropped from Argus server, try reconnecting\n");

               $isJson = Helper::isJsonString($data);

               if($isJson){
                   // Return Json decoded Argus Event
                   $this->publishArgusEvent($data);
                }else{
                   echo "Received: $data\n";
                }
    
            }
            
            // Close the connection
            socket_close($this->socket);

        }catch(\Exception $exp){
            socket_close($this->socket);
            throw new ArgusException($exp);
        }
    }

    private function publishArgusEvent($data){
        $argusEvent = new ArgusEvent();
        foreach ($data as $key => $value) $argusEvent->{$key} = $value;

        $this->eventBus->publish($argusEvent);
    }

    public function subscribe($subscriber, string $methodName){
        $this->eventBus->subscribe($subscriber, $methodName);
    }

    private function sendAuthData($socket, $username, $password){
        $connectionString = "<ArgusAuth>".$username.":".$password."</ArgusAuth>";
        socket_write($socket, $connectionString);
    }
}