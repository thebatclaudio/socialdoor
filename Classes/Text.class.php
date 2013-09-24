<?php

class Text{
    
    public static function get($what){
        return self::$$what;
    }
    
}

?>