<?php
class post {
	private $idPost;
	private $idUser;
    private $idOwner;
	private $content;
	private $date;

	public function setContent($content) {
		$this -> content = $content;
	}

	public function setDate($date) {
		$this -> date = $date;
	}

	public function setIdUser($idUser) {
		$this -> idUser = $idUser;
	}

	public function getContent() {
		return nl2br($this -> content);
	}

	public function getDate() {
        $array2 = explode(" ",$this->date);
        //divido in un array la data
        $array = explode("-", $array2[0]);
        //correggo i numeri da 1 a 9 cancellando lo 0 davanti (es. 01 diventa 1)
        switch($array[2]) {
            case "01" :
                $array[2] = "1";
                break;
            case "02" :
                $array[2] = "2";
                break;
            case "03" :
                $array[2] = "3";
                break;
            case "04" :
                $array[2] = "4";
                break;
            case "05" :
                $array[2] = "5";
                break;
            case "06" :
                $array[2] = "6";
                break;
            case "07" :
                $array[2] = "7";
                break;
            case "08" :
                $array[2] = "8";
                break;
            case "09" :
                $array[2] = "9";
                break;
        }
        
        if(substr($array[2], -1, 1) == "1"){
        	$array[2].= "st";
        } else if(substr($array[2], -1, 1) == "2"){
        	$array[2].= "nd";
        } else if(substr($array[2], -1, 1) == "3"){
        	$array[2].= "rd";
        } else {
        	$array[2].= "th";
        }
        //trasformo i mesi da numeri in stringe (es. 1 diventa Gennaio)
    switch($array[1]) {
            case "01" :
                $array[1] = "Jenuary";
                break;
            case "02" :
                $array[1] = "February";
                break;
            case "03" :
                $array[1] = "March";
                break;
            case "04" :
                $array[1] = "April";
                break;
            case "05" :
                $array[1] = "May";
                break;
            case "06" :
                $array[1] = "June";
                break;
            case "07" :
                $array[1] = "July";
                break;
            case "08" :
                $array[1] = "August";
                break;
            case "09" :
                $array[1] = "September";
                break;
            case "10" :
                $array[1] = "October";
                break;
            case "11" :
                $array[1] = "November";
                break;
            case "12" :
                $array[1] = "December";
                break;
        }
        //creo la stringa con la data in italiano
        $itDate = $array[2] . " " . $array[1] . " " . $array[0]." <span>at </span> ". substr($array2[1],0,5);
        return $itDate;	}

    public function getIdUser() {
        return $this -> idUser;
    }
    
    public function getIdOwner() {
        return $this -> idOwner;
    }

    public function getId() {
        return $this -> idPost;
    }

}
?>