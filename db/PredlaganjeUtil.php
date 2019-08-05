<?php

require_once('../classes/Category.php'); 
require_once('../classes/User.php');
require_once('../classes/Grupa.php');
require_once('../classes/Page.php');

class Predlaganje
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

    public function predlogPrijatelja($username)
    {
        try {
            // Korisnici koji nisu prijatelji $username
            $sql_user_friends = " SELECT DISTINCT User.*"
                        .   " FROM User"
                        .   " WHERE User.username NOT LIKE :username AND User.username NOT IN("
                        .   " SELECT DISTINCT Friends.User_username1"
                        .   " FROM Friends"
                        .   " WHERE Friends.User_username LIKE :username"
                        .   " UNION"
                        .   " SELECT DISTINCT Friends.User_username"
                        .   " FROM Friends"
                        .   " WHERE Friends.User_username1 LIKE :username)";
            $st = $this->conn->prepare($sql_user_friends);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->execute();
            $fetchUsers = $st->fetchAll();

            $prijatelji = array();
            foreach ($fetchUsers as $obj) {
                $u = new User($obj["first_name"], $obj["last_name"], $obj["username"], $obj["password"], '', $obj["birthday"], $obj["gender"], $obj["city"], $obj["school"]);
                $prijatelji[] = $u;
            }

            return $prijatelji;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function predlogStranica($username)
    {
        try {
            $sql_user_pages = "SELECT DISTINCT Page.*"
                        .   " FROM Page"
                        .   " WHERE Page.idPage" 
                        .   " NOT IN (SELECT user_page.Page_idPage FROM user_page WHERE user_page.User_username LIKE :username)"
                        .   " AND Page.Category_idCategory"
                        .   " IN (SELECT p.Category_idCategory FROM user_page AS up INNER JOIN page AS p"
                        .   " ON up.Page_idPage = p.idPage WHERE up.User_username LIKE :username) ";
            $st = $this->conn->prepare($sql_user_pages);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->execute();
            $fetchPages = $st->fetchAll();

            $stranice = array();
            foreach ($fetchPages as $obj) {
                $s = new Page($obj["idPage"],$obj["name"], $obj["Category_idCategory"],$obj["description"],$obj["dateFounded"],'','');
                $stranice[] = $s;
            }

            return $stranice;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function predlogGrupa($username)
    {
        try {
             $sql_user_groups = "SELECT DISTINCT `group`.*"
                        .   " FROM `group`"
                        .   " WHERE `group`.idGroup" 
                        .   " NOT IN (SELECT user_group.Group_idGroup FROM user_group WHERE user_group.User_username LIKE :username)"
                        .   " AND `group`.Category_idCategory"
                        .   " IN (SELECT g.Category_idCategory FROM user_group AS ug INNER JOIN `group` AS g"
                        .   " ON ug.Group_idGroup = g.idGroup WHERE ug.User_username LIKE :username) ";
            $st = $this->conn->prepare($sql_user_groups);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->execute();
            $fetchGroups = $st->fetchAll();

            $grupe = array();
            foreach ($fetchGroups as $obj) {
                $g = new Grupa($obj["name"], $obj["idGroup"], '', $obj["Category_idCategory"], '');
                $grupe[] = $g;
            }

            return $grupe;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function nadjiKorisnike($ime, $prezime) {
        try {
            $sql_users = "SELECT * FROM user WHERE user.first_name LIKE :firstname AND user.last_name LIKE :lastname";
            $st = $this->conn->prepare($sql_users);
            $st->bindValue(":firstname", $ime, PDO::PARAM_STR);
            $st->bindValue(":lastname", $prezime, PDO::PARAM_STR);
            $st->execute();
            $fetchUsers = $st->fetchAll();

            $korisnici = array();
            foreach ($fetchUsers as $obj) {
                $u = new User($obj["first_name"], $obj["last_name"], $obj["username"], $obj["password"], '', $obj["birthday"], $obj["gender"], $obj["city"], $obj["school"]);
                $korisnici[] = $u;
            }

            return $korisnici;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function nadjiStranice($naziv) {
        try {
            $sql_pages = "SELECT * FROM page WHERE page.name LIKE :name";
            $st = $this->conn->prepare($sql_pages);
            $st->bindValue(":name", $naziv, PDO::PARAM_STR);
            $st->execute();
            $fetchPages = $st->fetchAll();

            $stranice = array();
            foreach ($fetchPages as $obj) {
                $s = new Page($obj["idPage"],$obj["name"], $obj["Category_idCategory"],$obj["description"],$obj["dateFounded"],'','');
                $stranice[] = $s;
            }

            return $stranice;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function nadjiGrupe($naziv) {
        try {
             $sql_groups = "SELECT * FROM `group` WHERE `group`.name LIKE :name";
            $st = $this->conn->prepare($sql_groups);
            $st->bindValue(":name", $naziv, PDO::PARAM_STR);
            $st->execute();
            $fetchGroups = $st->fetchAll();

            $grupe = array();
            foreach ($fetchGroups as $obj) {
                $g = new Grupa($obj["name"], $obj["idGroup"], '', $obj["Category_idCategory"], '');
                $grupe[] = $g;
            }

            return $grupe;
        } catch (PDOException $e) {
            return false;
        }
    }

}