<?php


require_once ($_SERVER["DOCUMENT_ROOT"]."/API-Security/SecurityLib.php");
class UserCredentials  {
    public $username;
    public $password;

    function __construct($file) {
        $this->username =SecurityLib::GetCredential($file)->username;
        $this->password =SecurityLib::GetCredential($file)->password;

    }

}