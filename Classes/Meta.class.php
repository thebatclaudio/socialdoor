<?php

class Meta{
    
    public static $title = TITLE;
    public static $description = DESCRIPTION;
    public static $keywords = KEYWORDS;
    
    public static function get($what){
        return self::$$what;
    }
    
}

?>