<?php
//classe che contiene i dati del database
class MySqlClass {
    private $host = '';
    //nome dell'host
    private $db = '';
    //nome del db
    private $user = '';
    //user
    private $password = '';
    //password
    private $connected = false;
    //false se è disconnesso dal db, true se è connesso

    //metodo per connettersi al db
    public function connect() {
        //se non sono già connesso
        if (!$this -> connected) {
            //provo a connettermi
            if ($connection = mysql_connect($this -> host, $this -> user, $this -> password) or die(mysql_error())) {
                //se non si verificano errori nella connessione, provo a selezionare il db
                $select = mysql_select_db($this -> db, $connection) or die(mysql_error());
                $this -> connected = true;
            }
        } else {
            return true;
        }
    }

    //metodo per disconnettersi dal db
    public function disconnect() {
        if ($this -> connected) {
            if (mysql_close()) {
                $this -> connected = false;
                return true;
            } else {
                return false;
            }
        }
    }

    //metodo per interrogare il db
    public function query($sql) {
        if (isset($this -> connected)) {
            $sql = mysql_query($sql) or die();
            return $sql;
        } else {
            return false;
        }
    }

    //metodo per inserire dati sul db
    public function insert($t, $v, $r) {
        //se siamo connessi al db
        if (isset($this -> connected)) {
            //creo l'sql
            $sql = 'INSERT INTO ' . $t;
            //$t è la tabella in cui dobbiamo inserire i dati
            //se $r (i campi in cui devono essere inseriti i dati) è stato inserito (diverso da NULL)
            if ($r != null) {
                $sql .= ' (' . $r . ')';
                //aggiungo i campi da inserire all'sql
            }

            //$v è il vettore in cui sono presenti i valori da inserire nei campi
            for ($i = 0; $i < count($v); $i++) {
                //con un for li scorro tutti e controllo ogni valore per verificare che sia una stringa
                if (is_string($v[$i]))
                    $v[$i] = '"' . $v[$i] . '"';
                //se il valore è una stringa inserisco le virgolette
            }
            //infine trasformo il vettore in una stringa dove sono presenti tutti i valori presenti nel vettore
            //divisi da una virgola
            $v = implode(',', $v);
            //inserisco i valori nell'sql
            $sql .= ' VALUES (' . $v . ')';
            //eseguo la query
            $query = mysql_query($sql) or die(mysql_error());
        } else {
            return false;
        }
    }

}
?>
