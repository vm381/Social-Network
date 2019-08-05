<?php
require_once('../classes/Event.php'); 
require_once('../classes/Category.php'); 

class EventDatebase
{
    private $conn;

    public function __construct()
    {
        if ($config = parse_ini_file("config.ini")) {    
            $host = $config["host"];
            $database = $config["database"];
            $user = $config["user"];
            $password = $config["password"];
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function ucitajDogadjajeKorisnika($username)
    {
        try {
            $sql_user_events = " SELECT Event.*"
                    . " FROM User_Event INNER JOIN Event ON User_Event.Event_idEvent = Event.idEvent" 
                    . " WHERE User_Event.User_username = :username";
            $st = $this->conn->prepare($sql_user_events);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->execute();
            $fetchEvents = $st->fetchAll();

            $dogadjaji = array();
            foreach ($fetchEvents as $obj) {
                $name = $obj["name"];
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $obj["date"])->format("d/m/Y");
                $time = DateTime::createFromFormat('Y-m-d H:i:s', $obj["date"])->format("H:i");
                $category = $obj["Category_idCategory"];

                $dogadjaji[] = new Event('',$name,$date,$time,$category);
            }
            return $dogadjaji;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function sacuvajDogadjajKorisnika($username,$name,$date,$time,$category)
    {
        try {
            // Dodaj Event
            $sql1 = " INSERT INTO Event (name,date,Category_idCategory)"
                    . " VALUES (:name,:date,:category)";
            $st = $this->conn->prepare($sql1);
            $st->bindValue(":name", $name, PDO::PARAM_STR);
            $dateTemp = DateTime::createFromFormat("d/m/Y H:i", $date . " " . $time)->format('Y-m-d H:i:s');
            $st->bindValue(":date", $dateTemp, PDO::PARAM_STR);
            $st->bindValue(":category", $category, PDO::PARAM_STR);
            $st->execute();

            // Uzmi ID Event-a
            $sql2 = " SELECT Event.idEvent FROM Event WHERE Event.name =:name AND Event.Category_idCategory =:cat";
            $st2 = $this->conn->prepare($sql2);
            $st2->bindValue(":name", $name, PDO::PARAM_STR);
            $st2->bindValue(":cat", $category, PDO::PARAM_STR);
            $st2->execute();
            $id = $st2->fetch()["idEvent"];
           

            // Povezi Korisnika i Event
            $host = rand(1,127);
            $sql3 = " INSERT INTO User_Event (User_username, Event_idEvent, Event_Category_idCategory, host)"
                    . " VALUES (:username,:id,:cat,:host)";
            $st3 = $this->conn->prepare($sql3);
            $st3->bindValue(":username", $username, PDO::PARAM_STR);
            $st3->bindValue(":id", $id, PDO::PARAM_STR);
            $st3->bindValue(":cat", $category, PDO::PARAM_STR);
            $st3->bindValue(":host", $host, PDO::PARAM_STR);
            $st3->execute();
            
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obrisiDogadjaj($username,$name,$category)
    {
        try {
            // Uzmi ID Event-a
            $sql = " SELECT Event.idEvent FROM Event WHERE Event.name =:name AND Event.Category_idCategory =:cat";
            $st = $this->conn->prepare($sql);
            $st->bindValue(":name", $name, PDO::PARAM_STR);
            $st->bindValue(":cat", $category, PDO::PARAM_STR);
            $st->execute();
            $id = $st->fetch()["idEvent"];

            
            $sql2 = " DELETE FROM User_Event WHERE User_Event.User_username = :name AND User_Event.Event_idEvent = :id ";
            $st2 = $this->conn->prepare($sql2);
            $st2->bindValue(":name", $username, PDO::PARAM_STR);
            $st2->bindValue(":id", $id, PDO::PARAM_STR);
            $st2->execute();

            $sql2 = " DELETE FROM Event WHERE Event.idEvent = :id ";
            $st2 = $this->conn->prepare($sql2);
            $st2->bindValue(":id", $id, PDO::PARAM_STR);
            $st2->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function ucitajKategorije()
    {
        try {
            $sql_user_categories = " SELECT * FROM Category";
            $st = $this->conn->prepare($sql_user_categories);
            $st->execute();
            $fetchCategories = $st->fetchAll();

            $kategorije = array();
            foreach ($fetchCategories as $obj) {
                $id = $obj["idCategory"];
                $name = $obj["name"];

                $kategorije[] = new Category($id,$name);
            }
            return $kategorije;
        } catch (PDOException $e) {
            return false;
        }
    }

    /*  IZ FAJLA
    public static function ucitaj()
    {
        $json = file_get_contents("../db/files/events.json");
        $data = json_decode($json, true);
        $dogadjaji = array();
        foreach ($data["Dogadjaji"] as $obj) {
            $dogObj = new Event($obj["Naziv"],$obj["Datum"],$obj["Vreme"]);
            $dogadjaji[] = $dogObj;
        }
        return $dogadjaji;
    } */

    /*
    public static function sacuvaj($nizDogadjaja)
    {
        $data = "";
        $data .= "{\n";
        $data .= "\t \"Dogadjaji\": [\n";

        $broj = count($nizDogadjaja);
        foreach ($nizDogadjaja as $obj) {
            $data .= "\t\t { \n";
            $name = $obj->getName(); 
            $data .= "\t\t\t \"Naziv\": \"$name\", \n";
            $date = $obj->getDate(); 
            $data .= "\t\t\t \"Datum\": \"$date\", \n";
            $time = $obj->getTime(); 
            $data .= "\t\t\t \"Vreme\": \"$time\" \n";
            $data .= "\t\t }"; 
            if($broj > 1)
                $data .= ",";
            $data .= "\n";
            $broj--;         
        }

        $data .= "\t ]\n";
        $data .= "}";

        file_put_contents("../db/files/events.json", $data);
    } */

    public static function htmlZaDogadjaj($obj, $strDate)
    {
        $name = $obj->getName();
        $date = $obj->getDate();
        $time = $obj->getTime();
        $html = "<fieldset>
          <legend> Dogadjaj </legend>
            Naziv: $name <br>
            Datum: $date <br>
            Vreme: $time <br>
            <br>
            <a href=\"?newDate=$strDate&obrisi=OBRISI&name=$name\"> <button> OBRISI </button> </a>
         </fieldset>";
        return $html;
    }

    public static function htmlZaKategorije($kategorije)
    {
        $html = "Kategorija: <select name=\"izborKat\">";
        foreach ($kategorije as $obj) {
            $id = $obj->getId();
            $name = $obj->getName();
            $html .= "<option value=\"$id\">$name</option>";
        }
        $html .= "</select>";
        return $html;
    }

    public static function prviDanUMesecu($strMonth, $year)
    {
        // prvi dan u nedelji u mesecu prosledjenog datuma
        $firstDay = (new DateTime("first day of $strMonth $year"))->format('D');    

        $escape = 0;
        if($firstDay == 'Tue')
            $escape = 1;
        else if($firstDay == 'Wed')
            $escape = 2;
        else if($firstDay == 'Thu')
            $escape = 3;
        else if($firstDay == 'Fri')
            $escape = 4;
        else if($firstDay == 'Sat')
            $escape = 5;
        else if($firstDay == 'Sun')
            $escape = 6;
        return $escape;
    }

    public static function poslDanUMesecu($strMonth, $year)
    {
        // poslednji dan u nedelji u mesecu prosledjenog datuma
        $lastDay = (new DateTime("last day of $strMonth $year"))->format('D');  

        $escape = 0;
        if($lastDay == 'Sat')
            $escape = 1;
        else if($lastDay == 'Fri')
            $escape = 2;
        else if($lastDay == 'Thu')
            $escape = 3;
        else if($lastDay == 'Wed')
            $escape = 4;
        else if($lastDay == 'Tue')
            $escape = 5;
        else if($lastDay == 'Mon')
            $escape = 6;
        return $escape;
    }

    public static function postojiDogadjaj($nizDogadjaja, $datum)
    {
        $nadjen = false;
        // mala ispravka prosledjenog datuma: 05/10/2018 umesto 5/10/2018
        $datum = DateTime::createFromFormat('d/m/Y', $datum)->format("d/m/Y");
        foreach ($nizDogadjaja as $obj) {            
            if($obj->getDate() == $datum)
                return true;
        }
        return $nadjen;
    }
}