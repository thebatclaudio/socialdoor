        <div class="navbar navbar-inverse navbar-fixed-top socialdoor-navbar">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo HOME_URL ?>" title="<?php echo Meta::get("title"); ?>">
                  <img src="<?php echo HOME_URL ?>img/logo.png" alt="<?php echo Meta::get("title"); ?>" class="logo">
              </a>
            </div>
            <?php if(!Session::isLogged()): ?>
            <div class="navbar-collapse collapse">
               <ul class="nav navbar-nav navbar-right">
                    <li><a href="forgotPassword">Forgot your password?</a></li>
               </ul>
              <form class="navbar-form navbar-right" action="login" method="POST">
                <div class="form-group">
                  <input type="text" placeholder="Email" name="email" class="form-control">
                </div>
                <div class="form-group">
                  <input type="password" placeholder="Password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-socialdoor">Sign in</button>
              </form>
            </div>
            <?php else: ?>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if(Session::get("user")->pic): ?>
                            <img src="<?php echo HOME_URL ?>photos/<?php echo Session::get("user")->idUser; ?>" class="topbar-pic" />
                        <?php else: ?>
                            <img src="<?php echo HOME_URL ?>img/profile_photo.png" class="topbar-pic" />
                        <?php endif; ?>
                        <?php echo Session::get("user")->name." ".Session::get("user")->surname; ?> 
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="notifications/">Notifications <span class="badge" id="nofifications-badge"></span></a></li>
                      <li><a href="room/<?php echo Session::get("user")->idUser; ?>">Go to your room</a></li>
                      <li><a href="neighbours">Your neighbours</a></li>
                      <li><a href="editData">Edit your data</a></li>
                      <li class="divider"></li>
                      <li><a href="logout">Logout</a></li>
                    </ul>
                  </li>
                </ul>
                
                <form class="navbar-form navbar-right" role="search" action="<?php echo HOME_URL; ?>search" method="GET">
                  <div class="form-group">
                    <input type="text" name="q" class="form-control typeahead" placeholder="Search" id="search" data-provide="typeahead" data-items="10">
                  </div>
                </form>
                
                <script type="text/javascript">
                    $(document).ready(function(){
                      $.ajax({
                            type: 'get',
                            url: '<?php echo HOME_URL; ?>users4autocomplete',
                            data: "",
                            dataType: 'json',
                            success: function(data) {
                                  $('#search').typeahead({                                                                  
                                      name: 'users',
                                      local: data,
                                      template: [               
                                      	'<img class="pull-left topbar-pic" src="<?php echo HOME_URL;?>photos/{{pic}}">',                                                  
    									'<span class="user-name-search">{{name}}</span>'
    								  ].join(''),
    								  engine: Hogan                                                   
                                  });
                            }
                      });
                    });
                    
                    $('#search').bind('typeahead:selected', function(obj, datum) {        
						$(window.location).attr('href', '<?php echo HOME_URL; ?>room/'+datum.id);
					});
                </script>
            </div>
            <?php endif; ?>    
          </div>
        </div>