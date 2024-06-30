<?php

namespace Authorizer;
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/DataBaseHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator/SecretKey.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator/CipherLib.php");
class AuthorizerHandler
{


    function GenerateToken($userid): string
    {

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        $payload = json_encode(['user_id' => $userid,'iat' => time() + 3600,'user_right' => 123]);

        return $header."/".$payload;

    }


    static   function    CheckToken($token) :string{
        ;
        $secretkeyvalue = \SecurityLib::GetSecretKey("key.json");

        $secretkeyvalue = json_decode(json_encode($secretkeyvalue,true));

        $secretkeyvalue = (array($secretkeyvalue));
        $secretkeyvalue = (implode("/", (array)$secretkeyvalue[0]));
        $secretkeyvalue= (explode("/",$secretkeyvalue));
        $secretkeyvalue = $secretkeyvalue[1];


        if(isset($_COOKIE["identification"])){
            $cipheredtoken = $_COOKIE["identification"] ;
        }else{
            $_COOKIE["identification"] = null;
        }


        $ciphermethod = new \Authenticator\CipherLib();
        $uncipheredtoken = \Authenticator\CipherLib::UncipherToken($cipheredtoken);
        $header =  $uncipheredtoken['header'];
        $payload =  $uncipheredtoken['payload'];




        $signature = hash_hmac('sha256',  base64_encode(json_encode($header))   . "." . base64_encode(json_encode($payload)), $secretkeyvalue, true);
       // $signature = base64_encode($signature);
        $expectedsignature = str_replace(['+', '/', '='], ['-', '_', ''],base64_encode($signature));


       // var_dump($signature);


       // var_dump();

        if($uncipheredtoken["header"]['typ']!="JWT"){
            $res = "invalid";
            return $res;
        }

        if($uncipheredtoken["header"]['alg']!="HS256"){
            $res = "invalid";
            return $res;
        }



        if( hash_equals($expectedsignature,$uncipheredtoken['signature']) || $expectedsignature == $uncipheredtoken['signature']){



        if($payload['iat']<time()){
            echo  "<p> token expired please log at /login </p>";
            $res = "expired";
            return $res;

        }else{

            $res = "success";

            return  $res;
        }

        }else{
            echo "invalid token";
            $res ="invalid";
            return $res;
        }





        //$this->username =SecurityLib::GetCredential($file)->username;


    }





static function  ClearToken(): string
{
    $cipheredtoken = explode(".",$_COOKIE["identification"]);

    setcookie("identification",$cipheredtoken[1],time()-360000,"/");
    //$_COOKIE = "" ;
    echo "deconnexion réussie <br>";
    echo "allez sur la page /Login pour se Connecter";
    return "cookies cleared";
}


}