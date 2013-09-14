<?php

/**
 * Controller that manages posts
 */
class postsController extends Controller {
	
    protected $id;
    
    /**
     * Method that returns ten posts
     */
    public function loop(){
        $model = new postsModel();
        $userModel = new userModel();
        $page = Request::optional_param('page', 0);
        $idUser = Session::get("user")->idUser;
        $posts = $model->getPosts($page*10,($page+1)*10,$idUser);
        foreach($posts as $post){
            if($post->idOwner){
                $owner = $userModel->getRowByFields(array('idUser'=>$post->idOwner));
                $post->nameOwner = $owner->name;
                $post->surnameOwner = $owner->surname;
                $post->picOwner = $owner->pic;
            }
        }
        View::spit("loop",$posts);
    }
    
    /**
     * Method that submit a post
     */
    public function submitPost(){
        header("HTTP/1.1 200 OK");
        header('Content-type: application/json');
        
        $model = new postsModel();
        if($content = Request::optional_param('content', false)){
            $post->content = filter_var($this->checkPostContent($content), FILTER_SANITIZE_MAGIC_QUOTES);
            $post->idUser = Session::get("user")->idUser;
            $post->ip = Security::getIP();
            
            if($model->submitPost($post)){
                $userModel = new userModel();
                $user = $userModel->getRowByFields(array('idUser'=>$post->idUser));
                $result->status = 'OK';
                $response->userID = $user->idUser;
                $response->userName = $user->name." ".$user->surname;
                $response->pic = $user->pic;
                $response->content = $post->content;
                $response->postDate = View::formatDate(date('Y-m-d H:i:s'));
                $response->postID = $model->getLastInsertID();
                $result->response = $response;
                echo json_encode($result);
            } else {
                $result->status = "KO";
                echo json_encode($result);
            }
        } else {
            $result->status = "KO";
            echo json_encode($result);
        }
    }
    
    /**
     * Method that clean post and check if was inserted some links or youtube's video
     * @param $content (post's content)
     * @return string
     */
     private function checkPostContent($content){
         
         //change "<3" with heart symbol (lol)
         $content = str_replace("&lt;3","&hearts;",$content);
         
         //check if there is 'http' in post
         if(strstr($content,'http')){
             $httpPos = strpos($content,'http');
             $textBeforeLink = substr($content,0,$httpPos); //text before link
             $textBeforeLinkStart = substr($content,$httpPos,strlen($content)+1); //text that start when the link start and ends when the post content ends
             
             $string = explode(' ',$textBeforeLinkStart);
             $link = $string[0]; //the first word is the link
             $textAfterLink = "";
             //I must concatenate the words after the link
             for($i = 1; $i<count($string); $i++)
                $textAfterLink .= " ".$string[$i];
             
             //check if the link is a youtube's video
             if(strstr($link,'youtube')){
                 $video = explode("watch?v=",$link);
                 
                 //if there are other variables after video's id, i must delete them
                 $length = strlen($video[1]);
                 $i = 0;
                 $char = $video[1][$i];
                 $idVideo = "";
                 while($i<$length AND $char!="&"){
                     $i++;
                     $idVideo.=$char;
                     $char = $video[1][$i];
                 }
                 
                 $link = '<br /><iframe width=\'350\' height=\'208\' src=\'http://www.youtube.com/embed/'.$idVideo.'\' frameborder=\'0\' allowfullscreen></iframe><br />';
             } else if(strstr($link,'youtu.be')){
                  $video = explode("be/",$link);
                  $link = '<br /><iframe width=\'350\' height=\'208\' src=\'http://www.youtube.com/embed/'.$video[1].'\' frameborder=\'0\' allowfullscreen></iframe><br />';
             } else if(strstr($link,'.jpg') OR strstr($link,'.png') OR strstr($link,'.gif') OR strstr($link,'.JPG') OR strstr($link,'.PNG') OR strstr($link,'.GIF') OR strstr($link,'.jpeg') OR strstr($link,'.JPEG')){
                 //check if the link is an image
                  $link = '<br /><img src="'.$link.'" style="max-width: 300px"><br />';
             } else {
                 //else is a simple link
                 //extract the title from link's metatag
                 $source = file_get_contents($link);
                 
                 if(preg_match("/\<title\>(.*)\<\/title\>/", $source, $regs)){
                     //if there is title we use title into a tags
                     $link = '<a href="' . $link . '">' . $regs[1] . '</a>';
                 } else {
                     //else we use the link
                    $link = '<a href="' . $link . '">' . $link  . '</a>';
                 }
             }
             
             return htmlspecialchars($textBeforeLink) . $link . htmlspecialchars($textAfterLink);
         } else {
             return htmlspecialchars($content);
         }
     }
     
     public function viewPost(){
         $model = new postsModel();
         
         if($post = $model->getPostById($this->id)){
            View::spit("post",$post); 
         } else {
         	URL::redirect(HOME_URL."404");
         }
         
     }
}


?>