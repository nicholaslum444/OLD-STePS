<?php

// where the api key is stored
require_once($_SERVER['DOCUMENT_ROOT']."/php/apikey.php");

class UserAuthenticator {

    public static function isValidToken($token) {
        // call ivle api to validate token
        $url = "https://ivle.nus.edu.sg/api/Lapi.svc/Validate?APIKey="
            . apikey
            . "&Token="
            . $token;

        $apiResult = json_decode(file_get_contents($url));

        if (is_null($apiResult)) {
            return false;
        } else {
            return $apiResult->Success == true;
        }
    }

    public static function getUserType($token) {
        // call ivle api to get user type (if possible)
        // return one of {"student", "lecturer"}

        // dummy value of "student" for now
        return "student";
    }

    public static function getUserID($token) {
        $url = "https://ivle.nus.edu.sg/api/Lapi.svc/UserID_Get?APIKey="
            . apikey
            . "&Token="
            . $token;

        $apiResult = json_decode(file_get_contents($url));

        if (empty($apiResult)) {
            return false;
        } else {
            return $apiResult;
        }
    }

}

?>
