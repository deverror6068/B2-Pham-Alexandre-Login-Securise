<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Service/Service.php");



class Register extends Service
{


    public function Trig (){
        echo
       ' <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Page de Connection</title>
</head>
<body>
<h1>Inscription</h1>
<form action="../Service/Register2.php" method="post">
    <label >Nom d utilisateur : </label>
    <input type="text"  name="username" required>

    <label >Mot de passe: </label>
    <input type="password"  name="pwd" required>

    <label >Confirmez le Mot de passe: </label>
    <input type="password"  name="pwd2" required>

    <input type="submit" value="Envoyer">

</form>
</body>
</html>' ;

    }

function HandleForm() {
    echo $_POST["username"];
    echo $_POST["pwd"];

}

    static function EndPoint() {
        new Register();
    }



}
//new Register() ;
//(new Register)->HandleForm();
