<?php

class SecurityLib {
    public static function GetCredential($name) {
        $path = $_SERVER["DOCUMENT_ROOT"]."./../Credentials/" . $name;
     //   echo $path ;
        //var_dump( json_decode(file_get_contents($path)));
        return json_decode(file_get_contents($path));

    }
    public static  function  GetSecretKey($name){

            $path = $_SERVER["DOCUMENT_ROOT"]."./../CryptKey/" . $name;

         //   var_dump( json_decode(file_get_contents($path)));
            return json_decode(file_get_contents($path));


    }

}