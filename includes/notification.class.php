<?php
class notification {
	private $idNotification;
	private $idUser;
	private $content;
	private $read;
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
		return $this -> content;
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
		//trasformo i mesi da numeri in stringe (es. 1 diventa Gennaio)
		switch($array[1]) {
			case "01" :
				$array[1] = "Gennaio";
				break;
			case "02" :
				$array[1] = "Febbraio";
				break;
			case "03" :
				$array[1] = "Marzo";
				break;
			case "04" :
				$array[1] = "Aprile";
				break;
			case "05" :
				$array[1] = "Maggio";
				break;
			case "06" :
				$array[1] = "Giugno";
				break;
			case "07" :
				$array[1] = "Luglio";
				break;
			case "08" :
				$array[1] = "Agosto";
				break;
			case "09" :
				$array[1] = "Settembre";
				break;
			case "10" :
				$array[1] = "Ottobre";
				break;
			case "11" :
				$array[1] = "Novembre";
				break;
			case "12" :
				$array[1] = "Dicembre";
				break;
		}
		//creo la stringa con la data in italiano
		$itDate = $array[2] . " " . $array[1] . " " . $array[0]." <span>alle ore</span> ". substr($array2[1],0,5);
		return $itDate;
	}

    public function getOnlyDate() {
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
        //trasformo i mesi da numeri in stringe (es. 1 diventa Gennaio)
        switch($array[1]) {
            case "01" :
                $array[1] = "Gennaio";
                break;
            case "02" :
                $array[1] = "Febbraio";
                break;
            case "03" :
                $array[1] = "Marzo";
                break;
            case "04" :
                $array[1] = "Aprile";
                break;
            case "05" :
                $array[1] = "Maggio";
                break;
            case "06" :
                $array[1] = "Giugno";
                break;
            case "07" :
                $array[1] = "Luglio";
                break;
            case "08" :
                $array[1] = "Agosto";
                break;
            case "09" :
                $array[1] = "Settembre";
                break;
            case "10" :
                $array[1] = "Ottobre";
                break;
            case "11" :
                $array[1] = "Novembre";
                break;
            case "12" :
                $array[1] = "Dicembre";
                break;
        }
        //creo la stringa con la data in italiano
        $itDate = $array[2] . " " . $array[1] . " " . $array[0];
        return $itDate;
    }

    public function getIdUser() {
        return $this -> idUser;
    }

    public function getId() {
        return $this -> idNotification;
    }

}
?>