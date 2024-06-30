<?php

use Authorizer\AuthorizerHandler;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authorizer/AuthorizerHandler.php");

if (count($_COOKIE)>0){
    $Autorize = AuthorizerHandler::ClearToken() ;
}