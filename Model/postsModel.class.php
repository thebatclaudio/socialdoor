<?php

/**
 * Model that manages posts
 */
class postsModel extends Model {
	
	public function __construct() {
		parent::__construct();
        $this->table = "posts";
	}
    
    /**
     * Method that get posts from db
     * @param $startLimit (Ex. LIMIT startLimit,10)
     * @param $stopLimit (Ex. LIMIT 0,stopLimit)
     * @param $idUser (id of user logged)
     * @return array of objects with sql results
     */
    public function getPosts($startLimit, $stopLimit, $idUser){
        $sql = "SELECT idDoor, idOwner, name, surname, pic, idPost, date, content 
        FROM posts,openedDoors,users 
        WHERE openedDoors.idDoor = posts.idUser 
        AND openedDoors.idDoor = users.idUser 
        AND openedDoors.idUser = {$idUser} 
        AND accepted = 1 
        ORDER BY idPost DESC 
        LIMIT {$startLimit},{$stopLimit}";
        return $this->get_records_sql($sql);
    }
    
    /**
     * Method that save a post
     * @param $post
     * @return boolean
     */
     public function submitPost($post){
         $sql = "INSERT INTO posts(idUser,content,ip) VALUES({$post->idUser},'{$post->content}','{$post->ip}')";
         return $this->db->execute($sql);
     }
     
     /**
      * Method that get a post by id
      * @param $id (post's id)
      * @return object
      */
     public function getPostById($id){
         $sql = "SELECT * FROM posts,users WHERE idPost = {$id} AND posts.idUser = users.idUser";
         if($post = $this->get_record_sql($sql)){
             $returnPost->content = $post->content;
             $returnPost->datePost = $post->date;
             $returnPost->idPost = $post->idPost;
             $user->name = $post->name;
             $user->surname = $post->surname;
             $user->idUser = $post->idUser;
             $user->pic = $post->pic;
             $returnPost->user = $user;
           
             //get post comments
             $commentSql = "SELECT users.idUser,pic,name,surname,date,content 
             FROM comments,users 
             WHERE idPost = {$id} AND comments.idUser = users.idUser 
             ORDER BY idComment ASC";
             $returnPost->comments = $this->get_records_sql($commentSql);
           
             //check if post is a message in user's room
             if($post->idOwner != NULL){
                 //if post is a message in user's room i launch a query to get owner's data
                 $sql = "SELECT name,surname,idUser,pic FROM users WHERE idUser = {$post->idOwner}";
                 if($owner = $this->get_record_sql($sql)){
                     $returnPost->owner = $owner;
                     return $returnPost;
                 } else {
                     //if there is nobody with owner's id, the owner doesn't exists. so we return false
                     return false;
                 }
             } else {
                 $returnPost->owner = null;
                 return $returnPost;
             }
         } else {
             return false;
         }
     }
}


?>