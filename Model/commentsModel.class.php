<?php

/**
 * Model that manages comments
 */
class commentsModel extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->table = "comments";
    }
    
    public function saveComment($comment){
        $sql = "INSERT INTO comments(idPost,idUser,content,ip) VALUES({$comment->idPost},{$comment->idUser},'{$comment->content}','{$comment->ip}')";
        return $this->db->execute($sql);
    }
}


?>