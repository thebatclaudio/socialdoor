<?php
    /**
     * View class
     */
	class View {
		
		private $action;
		
        /**
         * Method that print a template
         * @param $what (the template to open)
         * @param $bundle (optional data to print into the template. Ex: posts in homepage)
         */
		public static function spit($what, $bundle = null){
			if(file_exists("View/Templates/".$what.".tpl")){
				ob_start();
				include("View/Templates/".$what.".tpl");
				$output = ob_get_contents();
				ob_end_clean();
				echo $output;
			}
		}
		
        /**
         * Static method that format a date
         * @param $date (date to format)
         * @return string (formatted date)
         */
        public static function formatDate($date){
            $date = date_create($date);
            return date_format($date, 'l jS F Y \a\t H:i');
        }
        
        public static function printImage($post){
            if($post->idOwner){
                if($post->picOwner){
                    echo '<a href="room/'.$post->idOwner.'" class="pull-left"><img src="./photos/'.$post->idOwner.'.jpg?imm='.rand(0,99999).'" class="media-object" width="79px"></a>';
                } else {
                    echo '<a href="room/'.$post->idOwner.'" class="pull-left"><img class="media-object" src="img/profile_photo.png"></a>';
                }
            } else {
                if($post->pic){
                    echo '<a href="room/'.$post->idDoor.'" class="pull-left"><img src="./photos/'.$post->idDoor.'.jpg?imm='.rand(0,99999).'" class="media-object" width="79px"></a>';
                } else {
                    echo '<a href="room/'.$post->idDoor.'" class="pull-left"><img class="media-object" src="img/profile_photo.png"></a>';
                }
            }
        }
	}

?>