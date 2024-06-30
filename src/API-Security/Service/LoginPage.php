<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Service/Service.php");

class LoginPage extends Service
{


    public function Trig (){



    echo ' <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
<h1>Connexion</h1>
<form action="../Service/Login.php" method="post">
    <label >Nom d utilisateur : </label>
    <input type="text"  name="username" required>

    <label >Mot de passe: </label>
    <input type="password"  name="pwd" required>

   

    <input type="submit" value="Envoyer">

</form>
</body>
</html>';

    }

    static function EndPoint() {
        new LoginPage();
    }

}

