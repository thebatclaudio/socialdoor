<?php

/**
 * Controller that manages comments
 */
class commentsController extends Controller {
	
    /**
     * Method that submit a comment
     */
    public function submitComment(){  
        header("HTTP/1.1 200 OK");
        header('Content-type: application/json');
        
        if($content = Request::optional_param('content', false) AND $idPost = Request::optional_param('idPost', false)){
            if(is_numeric($idPost)){
                $comment->content = $this->checkContent($content);
                $comment->idPost = $idPost;
                $comment->ip = Security::getIP();
                $comment->idUser = Session::get("user")->idUser;
                
                $model = new commentsModel();
                if($model->saveComment($comment)){
                    $result->status = "OK";
                    
                    $response->userID = $comment->idUser;
                    $response->pic = Session::get("user")->pic;
                    $response->userName = Session::get("user")->name." ".Session::get("user")->surname;
                    $response->content = $comment->content;
                    $response->commentDate = View::formatDate(date('Y-m-d H:i:s'));
                   
                    $result->response = $response;
                    echo json_encode($result);
                } else {
                    $result->status = "KO";
                    echo json_encode($result);
                }
            } else {
                $result->status = "KOo";
                echo json_encode($result);                
            }
        } else {
            $result->status = "KO";
            echo json_encode($result);           
        }
    }
    
    /**
     * Method that clean comment's content
     * @param $content (comment's content)
     * @return string (clean content)
     */
    private function checkContent($content){
             
         //change "<3" with heart symbol (lol)
         $content = str_replace("&lt;3","&hearts;",$content);
         
         return htmlspecialchars(trim($content));
    }
}


?>