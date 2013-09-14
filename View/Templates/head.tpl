    <head>
        <title><?php echo Meta::get("title"); ?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta content="<?php echo Meta::get("description"); ?>" name="description" />
        <meta content="<?php echo Meta::get("keywords"); ?>" name="keywords" />
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        
        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo HOME_URL ?>js/jquery-2.0.3.min.js"></script>
        
        <!-- Bootstrap -->
        <link href="<?php echo HOME_URL ?>css/bootstrap.css?<?php echo rand(0,99999);?>" rel="stylesheet" media="screen" />
        <script type="text/javascript" src="<?php echo HOME_URL ?>js/bootstrap.js"></script>  
        <script type="text/javascript" src="<?php echo HOME_URL ?>js/hogan.js"></script>
        <script type="text/javascript" src="<?php echo HOME_URL ?>js/typeahead.js"></script>  
        
        <link href="<?php echo HOME_URL ?>css/socialdoor.css?<?php echo rand(0,99999);?>" rel="stylesheet" media="screen" />
        
        <script type="text/javascript" src="<?php echo HOME_URL ?>js/ajax.js"></script>
    </head>