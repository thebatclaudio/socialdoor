<?php

	class genController extends Controller {
		
		protected function index(){
			View::spit('index');
		}
        
        protected function notFound(){
            View::spit('404');
        }
        
        protected function signup(){
        	Meta::$title = "Sign Up - ".TITLE;
        	View::spit('signup');
        }
	}

?>