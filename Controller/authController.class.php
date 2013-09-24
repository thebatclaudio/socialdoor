<?php

    /**
     * Controller that manage authentications (login and logout)
     */
    class authController extends Controller {
        
        /**
         * Method that allow users to login
         */
        protected function login(){
            //if user is not logged we can try to login
            if(!Session::isLogged()){
                //check if email and password are inserted
                if(Request::optional_param('email', false) AND Request::optional_param('password', false)){
                   
                    $email = Request::optional_param('email', false);
                    $password = Request::optional_param('password', false);
                   
                    $model = new userModel();
                    if($model->login($email, Security::hashing($email, $password))){
                       
                        Session::set('loggedin',1);
                        Session::set('user',$model->getRowByFields(array('email'=>$email)));
     
                        URL::redirect("index.php");
                    } else {
                        echo "non loggato";
                        //TODO: login form with error
                    }
                } else {
                    echo "dati non inseriti";
                    //TODO: login form
                }
            } else {
                URL::redirect("index.php");
            }
        }

        /**
         * Method that allow users to logout
         */
        protected function logout(){
            //if user is logged we can logout
            if(Session::isLogged()){
                Session::destroySession();
                URL::redirect("index.php?exit");
            } else {
                //else we redirect him at index.php
                URL::redirect("index.php");
            }
        }
    }

?>