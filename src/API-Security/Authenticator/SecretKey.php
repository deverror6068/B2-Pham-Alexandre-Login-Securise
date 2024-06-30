<?php

namespace Authenticator;
use SecurityLib;

require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/SecurityLib.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/UserService/UserService.php");

class SecretKey
{
    public $secretkey;

    function __construct($file)
    {
        $this->secretkey = SecurityLib::GetSecretKey($file)->secretkey;


    }
}