<?php

function __autoload($className)
{
    $directories = array('Classes','Controller','Model','View');
    
    foreach($directories as $directory){
        $ClassToInclude = $directory.'/'.$className.".class.php";
        if(file_exists($ClassToInclude)){
            include_once $ClassToInclude;
            return;
        }
    }
}

function printError($error){
    if(DEBUG) echo $error;
}

?>