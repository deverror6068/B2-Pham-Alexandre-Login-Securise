<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserService/UserService.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserDataBaseHandler.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator/AuthenticateToken.php");

class DeleteData extends UserService {

    function Trig() {
        $args = $this->GetArgs();
        $table = $args["table"];
        $filter = json_decode($args["filter"],true);
        $dbh = new UserDataBaseHandler();
        $ans = $dbh->DeleteData($table,$filter);

    }

    static function EndPoint() {
        new Authenticator\AuthenticateToken();
        echo "success";
        new DeleteData();
    }
}
