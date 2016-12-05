<?php $post = $bundle; ?>

<!DOCTYPE html>
<html>
    <?php include "head.tpl"; ?>
    <body>
        <?php include "topbar.tpl"; ?>
         
         <div class="container loop-container">
          <div class="row">
              <div class="col-lg-8 col-md-offset-2">
                  <div class="media">
                      <span class="pull-left">
                        <?php if($post->owner == null): ?>
                            <?php if(!$post->user->pic): ?>
                                <img class="media-object" src="../img/profile_photo.png">
                            <?php else: ?>
                                <img class="media-object" src="../photos/<?php echo $post->user->idUser; ?>">
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(!$post->owner->pic): ?>
                                <img class="media-object" src="../img/profile_photo.png">
                            <?php else: ?>
                                <img class="media-object" src="../photos/<?php echo $post->owner->idUser; ?>">
                            <?php endif; ?>
                        <?php endif; ?>
                      </span>
                      <div class="media-body" id="post-body">
                        <h4 class="media-heading">
                            <?php if($post->owner == null): ?>
                                <a href="<?php echo HOME_URL ?>room/<?php echo $post->user->idUser ?>"><?php echo $post->user->name." ".$post->user->surname; ?></a> says:
                            <?php else: ?>
                                <a href="<?php echo HOME_URL ?>room/<?php echo $post->owner->idUser ?>"><?php echo $post->owner->name." ".$post->owner->surname; ?></a> 
                                    > 
                                <a href="<?php echo HOME_URL ?>room/<?php echo $post->user->idUser ?>"><?php echo $post->user->name." ".$post->user->surname; ?></a>
                            <?php endif; ?>   
                        </h4>
                        
                        <div class="well socialdoor-well">
                            <?php echo $post->content; ?>
                        </div>
                        
                        <div class="pull-right post-footer">
                            <?php echo View::formatDate($post->datePost); ?>
                        </div>
                        
                        <div class="clear"></div>
                        
                        <?php foreach($post->comments as $comment): ?>
                            <div class="media">
                              <span class="pull-left">
                                  <?php if(!$comment->pic): ?>
                                        <img class="media-object" src="../img/profile_photo.png">
                                  <?php else: ?>
                                        <img class="media-object" src="../photos/<?php echo $comment->idUser; ?>">
                                  <?php endif; ?>
                              </span>
                              <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="<?php echo HOME_URL ?>room/<?php echo $comment->idUser ?>">
                                        <?php echo $comment->name." ".$comment->surname; ?>:
                                    </a>
                                </h4>
                                
                                <div class="well socialdoor-well">
                                    <?php echo $comment->content; ?>
                                </div>
                                
                                <div class="pull-right post-footer">
                                    <?php echo View::formatDate($comment->date); ?>
                                </div>                                
                              </div>
                            </div>    
                        <?php endforeach; ?>
                      </div>
                  </div>
              </div>
          </div>
          
          <div class="row">
            <div class="col-lg-8 col-md-offset-2">  
                <h2>Leave a comment</h2>
                <hr>
              <div class="media">
                  <span class="pull-left">
                    <?php if(!Session::get("user")->pic): ?>
                        <img class="media-object" src="img/profile_photo.png">
                    <?php else: ?>
                        <img class="media-object" src="../photos/<?php echo Session::get("user")->idUser; ?>">
                    <?php endif; ?>
                  </span>
                  <div class="media-body">
                        <div class="form-group">
                            <input type="hidden" id="post-id" value="<?php echo $post->idPost;?>" />
                            <textarea id="textarea-comment" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" id="submit-comment" class="btn btn-socialdoor pull-right">Submit</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </body>
</html>
