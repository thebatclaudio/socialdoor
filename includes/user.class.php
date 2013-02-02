<?php
//classe che contiene tutti i dati dell'user
class user {
    private $idUser;
    //id dell'user
    private $name;
    //nome
    private $surname;
    //cognome
    private $birthday;
    //data di nascita
    private $sex;
    //sesso
    private $city;
    //città
    private $email;
    //email
    private $pic;
    //immagine del profilo(0 o 1)
    private $website;
    //sito web (non obbligatorio)
    private $work;
    //lavoro (non obbligatorio)
    private $relationship;
	//situazione sentimentale (non obbligatorio)
	private $username;

    public function __construct($r) {
        //copio gli attributi dell'oggeto $r passato come parametro
        $this -> idUser = $r -> idUser;
        $this -> name = $r -> name;
        $this -> surname = $r -> surname;
        $this -> birthday = $r -> birthday;
        $this -> sex = $r -> sex;
        $this -> city = $r -> city;
        $this -> email = $r -> email;
        $this -> pic = $r -> pic;
        $this -> website = $r -> website;
        $this -> work = $r -> work;
		$this -> relationship = $r -> relationship;
		$this -> username = $r -> username;
    }

    public function getId() {
        return $this -> idUser;
    }

    public function getName() {
        return $this -> name;
    }

    public function getSurname() {
        return $this -> surname;
    }

    public function getCompleteName() {
        return $this -> name . " " . $this -> surname;
    }

    //metodo che da come valore di ritorno la data in italiano (es. 1 Gennaio 2012)
    public function getBirthday() {
        //divido in un array la data
        $array = explode("-", $this -> birthday);

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
        $itBirthday = $array[2] . " " . $array[1] . " " . $array[0];

        return $itBirthday;
    }

    //metodo che da come valore di ritorno il sesso (1=Maschio, 2=Femmina)
    //la funzione serve per effettuare dei controlli in caso di notifiche o altro
    public function getSex() {
        return $this -> sex;
    }

    //metodo che da come valore di ritorno la città
    public function getCity() {
        return $this -> city;
    }

    //metodo che da come valore di ritorno l'email
    public function getEmail() {
        return $this -> email;
    }

    //metodo che da come valore di ritorno il sesso dell'user in stringa (non 1 o 2 ma Maschio o Femmina)
    public function getItalianSex() {
        if ($this -> sex == 1) {
            return "Maschio";
        } else {
            return "Femmina";
        }
    }

    public function getPic() {
        return $this -> pic;
    }

    public function setName($name) {
        $this -> name = $name;
    }

    public function setBirthday($birthday) {
        $this -> birthday = $birthday;
    }

    public function setCity($city) {
        $this -> city = $city;
    }

    public function canIsee($idRoom) {
        if ($idRoom == $this -> idUser) {
            return TRUE;
        } else {
            $result = mysql_query("SELECT * FROM openedDoors WHERE idDoor = $idRoom AND idUser = " . $this -> idUser) or die();
            if (mysql_num_rows($result) > 0) {
                $line = mysql_fetch_array($result);
                if ($line['accepted'] == 1) {
                    return 1;
                } else if ($line['accepted'] == 0) {
                    return 2;
                }
            } else {
                return 0;
            }
        }
    }

    public function heRingsMyBell($id) {
        if ($id == $this -> idUser) {
            return 0;
        } else {
            $result = mysql_query("SELECT * FROM openedDoors WHERE idUser = $id AND idDoor = " . $this -> idUser) or die();
            if (mysql_num_rows($result) > 0) {
                $line = mysql_fetch_array($result);
                if ($line['accepted'] == 0) {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
    }

    public function getWork() {
        return $this -> work;
    }

    public function getWebsite() {
        if(strstr($this -> website, 'http://'))
			return $this -> website;
		else {
			return "http://".$this->website;
		}
    }

	public function getRelationship() {
		return $this -> relationship;
	}
	
	public function getUsername(){
		return $this -> username;
	}
}
