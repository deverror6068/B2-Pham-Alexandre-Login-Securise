<?php

namespace Authenticator;





use Authorizer\AuthorizerHandler;
require_once ($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authorizer/AuthorizerHandler.php");


class AuthenticateToken
{

function __construct(){
    error_reporting(0);
    $Autorize = AuthorizerHandler::CheckToken($_COOKIE) ;


    if($Autorize=="expired"){
        $errormessage = array(
            'Status' => 'Fail',
            'Errorcode' => '403',
            'Message' => " Unauthorized",

        );
        header("HTTP/1.1 403 Unauthorized");
        http_response_code(403);
        $encodedmessage = json_encode($errormessage);
        echo $encodedmessage;
        die(403);

    }
    if($Autorize=="invalid"){
        $errormessage = array(
            'Status' => 'Fail',
            'Errorcode' => '401',
            'Message' => " Not Authenticated",

        );
        header("HTTP/1.1 401 Not Authenticated");
        http_response_code(401);


        $encodedmessage = json_encode($errormessage);
        echo $encodedmessage;
        die(401);
    }
    if($Autorize=="sucess"){
        header("HTTP/1.1 200 Success");
        http_response_code(200);
        echo "success";



    }
}

}