<?php

    // php/login.php should be the callback address for the ivle login widget.
    // the url of this page would contain the token of the logged in user
    // this file then gets the token from the url and validates it.
    // once it is validated, then it will send back the token to the calling page.

    header("Content-Type: application/json");

    // where the api key is stored
    require_once("apikey.php");

    // run main
    main();

    // functions below---

    function main() {
        $result = [];
        $result["success"] = false;
        $result["data"] = null;
        $result["comments"] = null;

        if (isSet($_GET["token"])) {
            $data = [];

            // verify the token
            $token = $_GET["token"];
            $isValidToken = isValidToken($token);

            // set the user type and success
            if ($isValidToken) {
                $data["token"] = $token;
                $result["success"] = true;
                $data["userType"] = getUserType($token);
            }

            $result["data"] = $data;

        }

        echo json_encode($result);

    }

    function isValidToken($token) {
        // call ivle api to validate token
        $url = "https://ivle.nus.edu.sg/api/Lapi.svc/Validate?APIKey=".apikey."&Token=".$token;

        $curlResult = json_decode(file_get_contents($url));

        if (is_null($curlResult)) {
            return false;
        } else {
            return $curlResult->Success == true;
        }
    }

    function getUserType($token) {
        // call ivle api to get user type (if possible)
        // return one of {"student", "lecturer"}

        // dummy value of "student" for now
        return "student";
    }

?>
