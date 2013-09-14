<?php
    include "../config.php";
    
    $controller = new userController();
    $controller->set("action","getAllUsersJSON");
    $controller->play();
?>