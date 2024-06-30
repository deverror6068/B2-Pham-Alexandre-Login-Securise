<?php

namespace Authenticator;
require_once($_SERVER["DOCUMENT_ROOT"] . "/API-Security/Authenticator/SecretKey.php");

class CipherLib
{
    function CipherToken($uncipheredtoken): string
    {


        $tokentocipher = explode("/", $uncipheredtoken);

        $header = $tokentocipher[0];

        $payload = $tokentocipher[1];


        $secretkey = new \Authenticator\SecretKey("key.json");
        $secretkeyvalue = \SecurityLib::GetSecretKey("key.json");


        $secretkeyvalue = json_decode(json_encode($secretkeyvalue, true));

        $secretkeyvalue = (array($secretkeyvalue));

        $secretkeyvalue = (implode("/", (array)$secretkeyvalue[0]));

        $secretkeyvalue = (explode("/", $secretkeyvalue));

        $secretkeyvalue = $secretkeyvalue[1];

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

// Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

// Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretkeyvalue, true);

// Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature)); //'GfjgrthddkilftjhbqsdVu!fdgiojudr!'

// Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return $jwt;
    }


    static function UncipherToken($cipheredtoken)
    {
        //error_reporting(0);

        $explode = explode(".", $cipheredtoken);
        $signature = $explode[2];

        $visiblepayload = base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $cipheredtoken)[1])));
        $visibleheader = base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $cipheredtoken)[0])));



        // $visiblepayload = explode(",",$visiblepayload);
        //$visiblepayload = explode(":",$visiblepayload);

        $uncipheredpayload = (array)json_decode($visiblepayload);
        $uncipheredheader = (array)json_decode($visibleheader);


        $uncipheredtoken['header'] = $uncipheredheader;
        $uncipheredtoken["payload"] = $uncipheredpayload;
        $uncipheredtoken['signature'] = $signature;

        return $uncipheredtoken;
    }
}