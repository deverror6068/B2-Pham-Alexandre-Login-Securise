<?php
require_once ($_SERVER["DOCUMENT_ROOT"]."/API-Security/UserService/UserCredentials.php");
class UserConnexion {

    public PDO $dbh;

    public function __construct($name){
        $credential = new UserCredentials("user_credentials.json");
        $this->dbh = new  \PDO("mysql:host=localhost;dbname=".$name.";port=3306",$credential->username ,$credential->password);
    }

}

//Quel est l'enrte deux entre ton tableau issue du json et l'utilisation de la donnée ici.