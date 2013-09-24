<!DOCTYPE html>
<html>
	<?php include "head.tpl"; ?>
	<body>
        <?php include "topbar.tpl"; ?>
        
        <div class="signup-container container">
          <div class="row">
            <div class="col-lg-6">
              <h1><span class="glyphicon glyphicon-thumbs-up"></span> We are waiting for you!</h1>
              <img src="<?php echo HOME_URL."img/friends-fingers.jpg"; ?>" class="img-responsive" alt="We are waiting for you!">
              <h2>Sign up on <?php echo TITLE; ?> and you will be a member of a big social network where you can meet people and customize your personal page.<h2>
            </div>
            <div class="col-lg-6">
              <h1><span class="glyphicon glyphicon-thumbs-up"></span> Sign Up on SocialDoor!</h1>
              <form role="form" class="form-horizontal" method="POST">
                  <div class="form-group">
				    <label for="name" class="col-lg-2 control-label">Name</label>
				    <div class="col-lg-10">
				    	<input type="text" class="form-control" id="name" name="name" placeholder="Your name">
				 	</div>
				  </div>
				  <div class="form-group">
				    <label for="surname" class="col-lg-2 control-label">Surname</label>
				    <div class="col-lg-10">
				    	<input type="text" class="form-control" id="surname" name="surname" placeholder="Your surname">
				  	</div>
				  </div>
				  <div class="form-group">
				    <label for="email" class="col-lg-2 control-label">Email address</label>
				    <div class="col-lg-10">
				    	<input type="email" class="form-control" id="email" name="email" placeholder="Your email">
				  	</div>
				  </div>
				  <div class="form-group">
				    <label for="password" class="col-lg-2 control-label">Password</label>
				    <div class="col-lg-10">
				    	<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				  	</div>
				  </div>
				  <div class="form-group">
				    <label for="rpt-password" class="col-lg-2 control-label">Repeat Password</label>
				    <div class="col-lg-10">
				    	<input type="password" class="form-control" id="rpt-password" name="rpt-password" placeholder="Repeat Password">
				  	</div>
				  </div>
				  <div class="form-group">
				    <label for="city" class="col-lg-2 control-label">City</label>
				    <div class="col-lg-10">
				    	<input type="text" class="form-control" id="city" name="city" placeholder="Your city">
				  	</div>
				  </div>
				  <div class="form-group">
				    <label for="genre" class="col-lg-2 control-label">Genre</label>
				    <div class="col-lg-10">
					    <div class="radio">
					    	<input type="radio" id="genre" name="genre" value="1"> Man 
					  	</div>
					  	<div class="radio">
					    	<input type="radio" id="genre" name="genre" value="2"> Women 
					  	</div>
				  	</div>
				  </div>
				  <div class="form-group">
				    <label class="col-lg-2 control-label">Birthday</label>
				    <div class="col-lg-3">
				    	<select class="form-control" name="dd">
				    		<option value="-1">Day:</option>
				    		<?php 
				    			for($i=1;$i<10;$i++)
				    				echo "<option value='0$i'>$i</option>";
				    			for(;$i<=31;$i++)
									echo "<option value='$i'>$i</option>";
				    		?>
				    	</select>
				  	</div>
				  	<div class="col-lg-4">
			  			<select class="form-control" name="mm">
							<option value="-1" selected>Month:</option>
							<option value="01">Jenuary</option>
							<option value="02">February</option>
							<option value="03">March</option>
							<option value="04">April</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">August</option>
							<option value="09">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
					</div>
				  	<div class="col-lg-3">
				    	<select class="form-control" name="yy">
				    		<option value="-1">Year:</option>
				    		<?php 
				    			$i = date('Y')-16; //the minimum age is 16
				    			for(;$i>date('Y')-130;$i--)
				    				echo "<option value='$i'>$i</option>";
				    		?>
				    	</select>				  	
				    </div>
				  </div>
				  <div class="form-group">
				  	<div class="col-lg-offset-2 col-lg-10">				  
					  <div class="checkbox">
					    <label>
					      <input type="checkbox"> I agree with terms & conditions
					    </label>
					  </div>
					 </div>
				  </div>
				  <div class="form-group">
					  <div class="col-lg-offset-2 col-lg-10">
					  	<button type="submit" class="btn btn-socialdoor">Sign up!</button>
					  </div>
				  </div>
				</form>
           </div>
          </div>
          
          <hr>
    
          <footer>
            <p>&copy; Socialdoor 2012 - The open-source social network</p>
          </footer>
        </div>
	</body>
</html>