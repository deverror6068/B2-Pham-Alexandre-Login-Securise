<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Connexion.php");

class UserDataBase {
    public $Connexion;

    function __construct() {
        $this->Connexion = new  Connexion("events");
    }

    function SelectAll($table) {
        $acces = $this->Connexion->dbh;
        $data = $acces->prepare("select * from " . $table);
        $data->execute();
        $personne = $data->fetchAll();
        $this->DumpPersonne($personne);
    }

    function AddPersonne($nom, $prenom) {
        $acces = $this->Connexion->dbh;
        $sql = "INSERT INTO `personne`( `prenom`, `nom`) VALUES(:prenom, :nom)";
        echo $sql;
        $data = $acces->prepare($sql);
        $ans = $data->execute(array());
        echo $ans;
    }

    function DumpPersonne($tab) {
        foreach ($tab as $value) {
            echo $value['id'] . "\n";
            echo $value['prenom'] . "\n";
            echo $value['nom'] . "\n";
        }
    }
}