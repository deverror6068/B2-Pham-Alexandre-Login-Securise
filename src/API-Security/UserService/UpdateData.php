<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserService/UserService.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserDataBaseHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator/AuthenticateToken.php");
class UpdateData extends UserService {

    function Trig() {
        $args = $this->GetArgs();
        $table = $args["table"];
        $data = json_decode($args["data"],true);
        $filter = isset($args["filter"]) ?json_decode($args["filter"],true) : "";
        $dbh = new UserDataBaseHandler();
        $ans =$dbh->UpdateData($table,$data,$filter);

    }

    static function EndPoint() {
        new Authenticator\AuthenticateToken();
        echo "success";
        new UpdateData();
    }
}