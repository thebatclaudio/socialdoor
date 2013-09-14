<?php

/**
 * Controller that manages users
 */
class userController extends Controller {
	
    /**
     * Method that print a JSON with all users' names (for autocomplete in topbar's search form)
     */
    protected function getAllUsersJSON(){
        $model = new userModel();
        header("HTTP/1.1 200 OK");
        header('Content-type: application/json');
        echo json_encode($model->getAllUsersJSON());
    }
}


?>