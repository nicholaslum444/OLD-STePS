<?php

    // php/login.php should be called from the page that receives the ivle login token.
    // that page should POST the token to this script.
    // the token will be validated here.
    // then it will send the validation result to the calling page.
    // it will also start the session if the token is valid.

    // this call returns JSON objects.
    header("Content-Type: application/json");

    // where the api key is stored
    require_once("apikey.php");

    // run main
    main();


    // helper functions below ~~

    function main() {
        // main function, does the work
        $result = [];
        $result["success"] = false;
        $result["data"] = null;
        $result["comments"] = null;

        if (isSet($_POST["token"])) {
            // verify the token
            $token = $_POST["token"];
            $isValidToken = isValidToken($token);

            // set the user type and success
            if ($isValidToken) {
                // get the user type
                $userType = getUserType($token);

                // init the session
                session_start();
                $_SESSION["token"] = $token;
                $_SESSION["userType"] = $userType;
                $_SESSION["loggedIn"] = true;

                // place results in the json
                $result["success"] = true;

                $data = [];
                $data["token"] = $token;
                $data["userType"] = $userType;

                $result["data"] = $data;

            }

        }

        echo json_encode($result);

    }

    function isValidToken($token) {
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

    function getUserType($token) {
        // call ivle api to get user type (if possible)
        // return one of {"student", "lecturer"}

        // dummy value of "student" for now
        return "student";
    }

?>
