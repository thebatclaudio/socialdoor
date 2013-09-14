<!DOCTYPE html>
<html>
	<?php include "head.tpl"; ?>
	<body>
        <?php include "topbar.tpl"; ?>
    
        <div class="jumbotron center-text">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <img src="img/splash.png" alt="<?php echo Meta::get("title"); ?>" class="home-splash">
                    <h1><span class="big-text">SocialDoor</span> is an open-source social network!</h1>
                    <div class="row">
                        <a href="signup" title="Sign Up!" id="signup" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-star"></span> Sign up and try it</a>
                        <a href="https://github.com/ClaudioLaBarbera/socialdoor" class="btn btn-primary btn-lg" target="_blank" title="Contribute on GitHub!"><span class="glyphicon glyphicon-star"></span> Contribute on GitHub</a>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="container">
          <div class="row">
            <div class="col-lg-4">
              <h2><span class="glyphicon glyphicon-thumbs-up"></span> Open-source</h2>
              <hr>
              <p>SocialDoor is an open-source social network. You can reuse it however you want to create your own social network.</p>
              <p><a href="https://github.com/ClaudioLaBarbera/socialdoor" target="_blank">Find it on GitHub</a></p>
            </div>
            <div class="col-lg-4">
              <h2><span class="glyphicon glyphicon-thumbs-up"></span> AJAX based</h2>
              <hr>
              <p>SocialDoor is developed using AJAX (Asynchronous JavaScript and XML), PHP and MySQL.</p>
              <p>With AJAX you can use asynchronous HTTP requests, without interfering with the display and behavior of the existing page.</p>
           </div>
            <div class="col-lg-4">
              <h2><span class="glyphicon glyphicon-thumbs-up"></span> Customizable</h2>
              <hr>
              <p>You can customize SocialDoor however you want, and if you want you can <a href="https://github.com/ClaudioLaBarbera/socialdoor" target="_blank" title="SocialDoor on GitHub">contribute</a> to the growth of this project!</p>
              <p>There are so many things to do to make this a better social network!</p>
            </div>
          </div>
          
          <hr>
    
          <footer>
            <p>&copy; Socialdoor 2012 - The open-source social network</p>
          </footer>
        </div>
	</body>
</html>