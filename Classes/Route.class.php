<?php

/**
 * Class Router
 */
class Route {
	
    public static function play(){
        $request = new Request();
    
        if(!count($request->url_elements)){
            if(Session::isLogged()){
                $controller = new postsController();
                
                $controller->set("action","loop");
                $controller->play();
            } else {
                $controller = new genController();
                
                $controller->set("action","index");
                $controller->play();
            } 
        } else {
            $action = $request->url_elements[1];
            self::switchAction($action);
        }
    }
    
    public static function switchAction($action){
        switch($action){
            case "login":
                $controller = new authController();
                $controller->set("action","login");
                $controller->play();
            break;
            
            case "logout":
                $controller = new authController();
                $controller->set("action","logout");
                $controller->play();
            break; 
            
            case "users4autocomplete":
                $controller = new userController();
                $controller->set("action","getAllUsersJSON");
                $controller->play();
            break;   
            
            case "submitPost":
                $controller = new postsController();
                $controller->set("action","submitPost");
                $controller->play();
            break;            
                
            case "404":
                $controller = new genController();
                $controller->set("action","notFound");
                $controller->play();
            break;
            
            case "post":
            	$request = new Request();
                $controller = new postsController();
                $controller->set("action","viewPost");
                $controller->set("id",$request->url_elements[2]);
                $controller->play();
            break;
            
            case "comment":
                $controller = new commentsController();
                $controller->set("action","submitComment");
                $controller->play();                
            break;
            
            case "signup":
                $controller = new genController();
                $controller->set("action","signup");
                $controller->play();
            break;
                
            default:
                URL::redirect(HOME_URL."404");
            break;
        }
    }
    
}


?>