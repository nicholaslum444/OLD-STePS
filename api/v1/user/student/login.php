<?php

    // php/login.php should be called from the page that receives the ivle login token.
    // that page should POST the token to this script.
    // the token will be validated here.
    // then it will send the validation result to the calling page.
    // it will also start the session if the token is valid.

    // this call returns JSON objects.
    header("Content-Type: application/json");

    require_once($_SERVER['DOCUMENT_ROOT']."/php/helpers/userAuthenticator.php");

    // run main
    main();


    // helper functions below ~~

    function main() {
        // main function, does the work
        $result = [];
        $result["data"] = null;
        $result["meta"] = null;

        if (isSet($_POST["token"])) {
            // verify the token
            $token = $_POST["token"];
            $isValidToken = UserAuthenticator::isValidToken($token);

            // set the user type and success
            if ($isValidToken) {
                // get the user type
                $userType = UserAuthenticator::getUserType($token);

                // init the session
                session_start();
                $_SESSION["token"] = $token;
                $_SESSION["userType"] = $userType;
                $_SESSION["loggedIn"] = true;

                // place results in the return obj
                $meta = [];
                $meta["success"] = true;
                $meta["code"] = 200;

                $result["meta"] = $meta;

                $data = [];
                $data["token"] = $token;
                $data["userType"] = $userType;

                $result["data"] = $data;

            } else {
                $meta = [];
                $meta["success"] = false;
                $meta["code"] = 401;
                $meta["errorType"] = "Unauthorized";
                $meta["errorMessage"] = "Token is invalid.";

                $result["meta"] = $meta;
            }

        } else {
            $meta = [];
            $meta["success"] = false;
            $meta["code"] = 400;
            $meta["errorType"] = "Bad Request";
            $meta["errorMessage"] = "No token specified.";

            $result["meta"] = $meta;
        }

        echo json_encode($result);

    }

?>
