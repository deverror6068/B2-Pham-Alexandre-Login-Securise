<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserService/UserService.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserDataBaseHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator/AuthenticateToken.php");


class CreateData extends UserService {

    function Trig() {
        $args = $this->GetArgs();
        $table = $args["table"];
        $data = json_decode($args["data"],true);
        $dbh = new UserDataBaseHandler();

        $res = $dbh->CreateData($table,$data);

    }

    static function EndPoint() {
        new Authenticator\AuthenticateToken();
        echo "success";
        new CreateData();
    }
}