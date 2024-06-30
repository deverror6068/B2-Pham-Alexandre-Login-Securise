<?php

use Authorizer\AuthorizerHandler;

require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserService/UserService.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authorizer/AuthorizerHandler.php");
class Cookies extends UserService
{
    function Trig()
    {
        var_dump($_COOKIE,"e",$_SERVER);
        var_dump($_REQUEST);
}

    static function EndPoint() {
        new Cookies();

        echo "efgrth";
        $Autorize = (new AuthorizerHandler)->CheckToken($_COOKIE) ;

    }
}