<?php

    // php/login.php should be called from the page that receives the ivle login token.
    // that page should POST the token to this script.
    // the token will be validated here.
    // then it will send the validation result to the calling page.
    // it will also start the session if the token is valid.

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

        if (isSet($_POST["token"])) {
            $data = [];

            // verify the token
            $token = $_POST["token"];
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
