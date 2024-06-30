<?php

use Authenticator\CipherLib;
use Authorizer\AuthorizerHandler;

//require_once ($_SERVER["DOCUMENT_ROOT"]."/API-Security/UserService/TokenHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/DataBaseHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Service/Register.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Service/LoginPage.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authorizer/AuthorizerHandler.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator\CipherLib.php");

//include
class Login
{
function __construct(){
    if(count($_COOKIE)<=0){
    $col0 = "username";
    $filter0 = "id";
    $dbh0 = new DataBaseHandler();
    $res0 = $dbh0->SelectData("users",$col0,$filter0,"true",$_POST["username"]);


    $col = "username";
    $filter = "username";
    $dbh = new DataBaseHandler();
    $res = $dbh->SelectData("users",$col,$filter,"true",$_POST["username"]);
    if(count($res)>0){

        $col4 = "username";
        $filter4 = "attempts";
        $dbh4 = new DataBaseHandler();
        $res4 = $dbh4->SelectData("users",$col4,$filter4,"true",$_POST["username"]);
        $attempts = $res4["attempts"];

        $col7 = "username";
        $filter7 = "expire_at";
        $dbh7 = new DataBaseHandler();
        $res7 = $dbh7->SelectData("users",$col7,$filter7,"true",$_POST["username"]);
        $timeexp = $res7["expire_at"];



        if ($attempts>=5 && $timeexp<time()){


            $filter8 = "";
            $data["username"] = $_POST["username"];
            $timeexp = time() +3600;
            $serverarg3 = "attempts =''";
            $dbh8 = new DataBaseHandler();
            $res8 = $dbh8->UpdateData("users",$data,$filter8,"true",$serverarg3);



            $data["username"] = $_POST["username"];
            $timeexp = time() +3600;
            $serverarg4 = "expire_at =''";
            $dbh10 = new DataBaseHandler();
            $res10 = $dbh8->UpdateData("users",$data,$filter8,"true",$serverarg4);

        }

        $col9 = "username";
        $filter9 = "attempts";
        $dbh9 = new DataBaseHandler();
        $res9 = $dbh9->SelectData("users",$col9,$filter9,"true",$_POST["username"]);
        $attempts = $res9["attempts"];


        if($attempts>=5 && $timeexp>time())
        {

               new LoginPage();
               echo  "Vous avez entré des informations incorrectes à de trop nombreuses reprises  veuillez réessayer plus tard";


        }
        else
        {


        $col1 = "username";
        $filter1 = "pwd";
        $dbh1 = new DataBaseHandler();
        $res1 = $dbh1->SelectData("users",$col1,$filter1,"true",$_POST["username"]);
        $dbpwd = $res1["pwd"] ;

        $col2 = "username";
        $filter2 = "salt";
        $dbh2 = new DataBaseHandler();
        $res2 = $dbh2->SelectData("users",$col2,$filter2,"true",$_POST["username"]);

        $dbsalt = $res2["salt"];

        $givenpwd = $_POST["pwd"].$dbsalt;

        $hashedgivenpwd = hash("sha512",$givenpwd) ;



        if($dbpwd===$hashedgivenpwd){

            $uncipheredtoken = (new AuthorizerHandler)->GenerateToken($res0['id']);

          $cipheredtoken  = (new CipherLib())->CipherToken($uncipheredtoken);


        $cookie =  setcookie("identification",$cipheredtoken,time()+3600,"/");



            $token = $cookie;

            echo "<p style='color: green'>connexion réussie</p>";



        }
        else
        {

            new LoginPage();
            echo "<p style='color: red'> le mot de passe ou le nom d'utilisateur est incorrect</p>";
            $col3 = "username";
            $filter3 = "attempts";
            $dbh3 = new DataBaseHandler();
            $res3 = $dbh3->SelectData("users",$col3,$filter3,"true",$_POST["username"]);
            $attempts = $res3["attempts"];
           // $attempts = $attempts + 1;



            $data["username"] = $_POST["username"];
            //$data["field"] = "username";
           // $filter5="attempts" ;
            $filter5 = "attempts ='1'";
            $dbattempts = $attempts + 1;
            $serverarg = "attempts ='".$dbattempts."'";
            $dbh5 = new DataBaseHandler();
            $res5 = $dbh5->UpdateData("users",$data,$filter5,"true",$serverarg);

            if ($dbattempts >=5){
                $filter6 = "";
                $timeexp = time() +3600;
                $serverarg2 = "expire_at ='".$timeexp."'";
                $dbh6 = new DataBaseHandler();
                $res6 = $dbh6->UpdateData("users",$data,$filter6,"true",$serverarg2);

            }
        }
    }

    }
    else
    {

        new LoginPage();
        echo "<p style='color: red'> le mot de passe ou le nom d'utilisateur est incorrect</p>";

    }
    }
    else
    {
        echo "vous etes déja connecté veuillez vous déconnecter si vous souhaitez vous connecter";
    }
}


}



new Login();