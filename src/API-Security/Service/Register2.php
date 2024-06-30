<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Service/Register.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/DataBaseHandler.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authorizer/AuthorizerHandler.php");

Class HandleRegister{

    function __construct()
    {
        if(count($_COOKIE)<=0){


            if(strpos($_POST["pwd"], " ") || strpos($_POST["pwd"], ">") ||strpos($_POST["pwd"], ">")||strpos($_POST["pwd"], "$")||strpos($_POST["pwd"], '"')  ){
                new Register();
                echo "<p style='color: red'> caracteres speciaux non autorises</p>";

            }else{


                if ($_POST["pwd2"]!=$_POST["pwd"]){
                    new Register();
                    //  print(":/");
                    echo "<p style='color: red'> les deux mots de passe ne correspondent pas </p>";

                }else{
                    if (strlen($_POST["pwd"])<8){
                        new Register();
                        echo "<p style='color: red'> le mot de passe est trop court  </p>";
                    }else{
                        //$col[]="";
                        $col = "username";
                        $filter = "username";

                        $dbh = new DataBaseHandler();
                        $res = $dbh->SelectData("users",$col,$filter,"true",$_POST["username"]);

                        if(count($res)<=0){

                            $data["username"] = $_POST["username"];

                            $salt = bin2hex(random_bytes(16)); //a verifier
                            $saltedpwd = $_POST["pwd"].$salt; //a verifier
                            $hashedpwd = hash("sha512",$saltedpwd) ;

                            $data["pwd"] = $hashedpwd ;
                            $data["salt"] = $salt;

                            $dbh = new DataBaseHandler();
                            $res = $dbh->CreateData("users",$data);


                            $pwdtest =$_POST["pwd"].$salt ;

                            echo "<p style='color: green'>Votre inscription a bien été prise en compte</p>";

                            // CreateToken();
                        }else{
                            new Register();
                            echo "<p style='color: red'> le nom d'utilisateur est déja pris  </p>";
                        }

                    }



                }
            }
        }else{
            echo "<p style='color: red'>vous ne pouvez vous enregister si vous etes déja connecté</p>";
        }
}



}
new HandleRegister();

