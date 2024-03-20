<?php

namespace Khelechy\Argus\Helpers;

class Helper {
    
    public static function isJsonString($str) : bool {

        $decoded = json_decode($str);
        if($decoded === null){
            return false;
        }
        return true;
    }
}