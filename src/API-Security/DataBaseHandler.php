<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Connexion.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserService/Utils.php");
class DataBaseHandler
{
    public $Connexion;
    public $Utils ;

    function __construct()
    {
        $this->Connexion = new  Connexion("auth");
        $this->Utils = new Utils();
    }

    function SelectData($table, $filter, $col,$serverrequest="false",$serverrequestarg="")
    {

    if($serverrequest =="false"){

        $acces = $this->Connexion->dbh;
        $queryString = '';
        if ($filter == "") {
            $sql = $acces->prepare("select $col from $table");
        } elseif (count($filter) > 1) {
            $queryString = '';
            foreach ($filter as $key => $value) {
                $queryString .= "$key= \"$value\" AND ";
            }
            // Supprimer le " AND " final
            $queryString = rtrim($queryString, ' AND ');
            $sql = $acces->prepare("select $col from $table WHERE  $queryString");
        } else {
            $queryString = '';
            foreach ($filter as $key => $value) {

                $queryString .= "$key= \"$value\"";

            }

            $sql = $acces->prepare("select $col from $table WHERE $queryString");
        }

    }else{
        $acces = $this->Connexion->dbh;
        $queryString = '';
        if ($filter == "") {
            $sql = $acces->prepare("select $col from $table");
        }
                $queryString .= "$filter = \"$serverrequestarg\"";


            $sql = $acces->prepare("select $col from $table WHERE $queryString");

    }
        $ans = $sql->execute();
        if (!$ans){
            return  false;
        }
        $data = $sql->fetch();
        $res = $this->Utils->ArrayKeyOnly($data);

        return $res;
    }

    Function SelectDataJoin($table,$col,$key,$filter) {
        $acces = $this->Connexion->dbh;
        $table1  = $table["table1"];
        $table2 = $table["table2"];
        $key1 = $key["key1"];
        $key2 = $key["key2"];
        $queryString = '';
        foreach ($filter as $key => $value) {
            $queryString .= "$key=$value";
        }
        $sql = $acces->prepare("select $col from $table1 join $table2 on $key1 = $key2 WHERE $queryString");
        $sql->execute();
        $data = $sql->fetchAll();
        // Tableau pour stocker les nouvelles données
        $realdata = $this->Utils->ArrayKeyOnly2D($data);
        return $realdata;
    }


    function CreateData($table, $data)
    {

        $col = "`" . implode('`,`', array_keys($data)) . "`";
        $values = "'" . implode("','", array_values($data)) . "'";
        $acces = $this->Connexion->dbh;
        $sql = "INSERT into $table ($col) values ($values);";
        try {
            $req = $acces->prepare($sql);
            $res = $req->execute();
        } catch (PDOException $e) {

        }
        return $res;
    }



    function UpdateData($table, $data,$filter,$serverrequest="false",$serverrequestarg="")
    {

        $dataString = "";
        foreach ($data as $key => $value){
            //print_r($key);
            $dataString .= "`".$key."`= '".$value ."',";
        }
        $dataString = rtrim($dataString, ',');
        $acces = $this->Connexion->dbh;
        $queryString = '';
        if($serverrequest=="false"){
            if (count($filter) > 1) {
                foreach ($filter as $key => $value) {
                    $queryString .= "$key=$value AND ";
                }
                // Supprimer le " AND " final
                $queryString = rtrim($queryString, ' AND ');
                $sql = "UPDATE $table SET $dataString WHERE $queryString";
            } else {

                foreach ($filter as $key => $value) {
                    if (gettype($value) == "string")
                        $queryString .= "$key= '".$value ."'";
                    else {
                        $queryString .= "$key= $value";
                    }
                }

                $sql = "UPDATE $table SET $dataString WHERE $queryString;";

            }
        }else{
          //  $dataString = $data;

           // $filter = array($filter);

                $queryString = $serverrequestarg;

                 //   $queryString = "$filter= '".$serverrequestarg."'";




            $sql = "UPDATE $table SET  $queryString WHERE $dataString; ";


        }

            $req = $acces->prepare($sql);
            return $req->execute();

    }


//    function DeleteData($table, $filter)
//    {
//
//        $acces = $this->Connexion->dbh;
//        $queryString = '';
//        if (count($filter) > 1) {
//            foreach ($filter as $key => $value) {
//                $queryString .= "$key=$value AND ";
//            }
//            // Supprimer le " AND " final
//            $queryString = rtrim($queryString, ' AND ');
//            $sql = "DELETE FROM $table WHERE $queryString;";
//        } else {
//            foreach ($filter as $key => $value) {
//                $queryString .= "$key=$value";
//            }
//            $sql = "DELETE FROM $table WHERE $queryString;";
//        }
//            $req = $acces->prepare($sql);
//            $req->execute();
//    }

    function DeleteData($table, $filter)
    {
        $acces = $this->Connexion->dbh;
        $queryString = '';

        // Vérifiez si $filter est un tableau avant d'utiliser count()
        if (is_array($filter) && count($filter) > 1) {
            foreach ($filter as $key => $value) {
                $queryString .= "$key=$value AND ";
            }
            // Supprimer le " AND " final
            $queryString = rtrim($queryString, ' AND ');
            $sql = "DELETE FROM $table WHERE $queryString;";
        } else {
            foreach ($filter as $key => $value) {
                $queryString .= "$key= '".$value ."'";
            }
            $sql = "DELETE FROM $table WHERE $queryString;";
        }
        $req = $acces->prepare($sql);
        return $req->execute();
    }


}