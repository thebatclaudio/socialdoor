<?php

class URL {
    
    public static function redirect($url){
        if (!headers_sent())//If headers not sent yet... then do php redirect
        {
            header('Location: '.$url); exit();
        }
        else //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
        {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$url.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
            echo '</noscript>';
            exit;
        }
    }
    
}

?>