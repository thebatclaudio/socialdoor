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
                        <?php if(!Session::get("user")->pic): ?>
                            <img class="media-object" src="img/profile_photo.png">
                        <?php else: ?>
                            <img class="media-object" src="photos/<?php echo Session::get("user")->idUser; ?>">
                        <?php endif; ?>
                      </span>
                      <div class="media-body">
                            <div class="form-group">
                                <h4 class="media-heading">Hi <?php echo Session::get("user")->name; ?>! What's up?</h4>
                                <textarea id="textarea-post" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" id="submit-post" class="btn btn-socialdoor pull-right">Submit</button>
                      </div>
                  </div>
              </div>
          </div>
          
          <div class="row">
            <div class="col-lg-8 col-md-offset-2">  
                <h2>Last posts</h2>
                <hr>
            </div>
          </div>
          
          <div id="last-posts-container">
              <?php foreach($bundle as $post): ?>
              <div class="row posts-row">
                  <div class="col-lg-8 col-md-offset-2">
                      <div class="media">
                          <?php View::printImage($post); ?>
                          <div class="media-body">
                            <?php if(!$post->idOwner): ?>
                            <h4 class="media-heading"><a href="room/<?php echo $post->idDoor; ?>"><?php echo $post->name." ".$post->surname; ?></a> writes:</h4>
                            <?php else: ?>
                            <h4 class="media-heading"><a href="room/<?php echo $post->idOwner; ?>"><?php echo $post->nameOwner." ".$post->surnameOwner; ?></a> > <a href="room/<?php echo $post->idDoor; ?>"><?php echo $post->name." ".$post->surname; ?></a></h4>    
                            <?php endif; ?>
                            <div class="well socialdoor-well">
                                <?php echo $post->content; ?>
                            </div>
                            <div class="pull-right post-footer">
                                <?php echo View::formatDate($post->date); ?> - <a href="post/<?php echo $post->idPost ?>">Comment</a>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
              <?php endforeach; ?>
           </div>
        </div>
    </body>
</html>
