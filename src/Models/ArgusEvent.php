<?php

namespace Khelechy\Argus\Models;

class ArgusEvent{

    public $Action;
    public $ActionDescription;
    public $Name;
    public $Timestamp;

    public function __construct($jsonData = '')
    {
        $data = json_decode($jsonData, true);

        $this->Action = $data['Action'] ?? null;
        $this->ActionDescription = $data['ActionDescription'] ?? null;
        $this->Name = $data['Name'] ?? null;
        $this->Timestamp = $data['Timestamp'] ?? null;
    }

}
