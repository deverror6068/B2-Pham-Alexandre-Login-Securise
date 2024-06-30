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
        // print_r(json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[2])))));
       // $secretkey = new \Authenticator\SecretKey("key.json");
        $secretkeyvalue = \SecurityLib::GetSecretKey("key.json");
        var_dump($secretkeyvalue);
        var_dump($token);
        $secretkeyvalue = json_decode(json_encode($secretkeyvalue,true));
        var_dump((array)$secretkeyvalue);
        $secretkeyvalue = (array($secretkeyvalue));
        $secretkeyvalue = (implode("/", (array)$secretkeyvalue[0]));
        $secretkeyvalue= (explode("/",$secretkeyvalue));
        $secretkeyvalue = $secretkeyvalue[1];
        var_dump($secretkeyvalue);
       // return  $secretkeyvalue;
        $cipheredtoken = $_COOKIE["identification"] ;
       // $explode = explode(".",$cipheredtoken["identification"]);
       // var_dump($explode);
        var_dump($_COOKIE);
        $ciphermethod = new \Authenticator\CipherLib();
        $uncipheredtoken = \Authenticator\CipherLib::UncipherToken($cipheredtoken);
        $header =  $uncipheredtoken['header'];
        $payload =  $uncipheredtoken['payload'];

        var_dump($uncipheredtoken);
        var_dump($uncipheredtoken['signature']);
        var_dump(base64_decode($secretkeyvalue));


        $signature = hash_hmac('sha256',  base64_encode(json_encode($header))   . "." . base64_encode(json_encode($payload)), $secretkeyvalue, true);
       // $signature = base64_encode($signature);
        $expectedsignature = str_replace(['+', '/', '='], ['-', '_', ''],base64_encode($signature));
        var_dump($signature);

       // var_dump($signature);
        var_dump(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        var_dump(json_encode($uncipheredtoken["header"]));
        var_dump($expectedsignature);
        var_dump($uncipheredtoken['signature']);
        var_dump($signature);
        var_dump($uncipheredtoken["header"]['typ']==="JWT");

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
            echo  "<p> token expired please login at /login </p>";
            $res = "expired";
            return $res;

        }else{
            echo "connexion succeed";
            $res = "success";
            var_dump($_COOKIE);
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
    var_dump($_COOKIE);
    var_dump($cipheredtoken[1]);
    setcookie("identification",$cipheredtoken[1],time()-360000,"/");
    //$_COOKIE = "" ;


            var_dump($_COOKIE);
    return "cookies cleared";
}


}