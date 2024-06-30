<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserService/UserService.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserDataBaseHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator/AuthenticateToken.php");

class SelectData extends UserService {
//
    function Trig() {
        $args = $this->GetArgs();
        $table = $args["table"];
        $col = $args["col"] ?? "*";
        $filter = isset($args["filter"]) ?json_decode($args["filter"],true) : "";
        $dbh = new UserDataBaseHandler();
        $res =$dbh->SelectData($table,$filter,$col);
        echo  json_encode($res);
    }

    static function EndPoint() {
        new Authenticator\AuthenticateToken();
        new SelectData();
    }
}