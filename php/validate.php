<?php

    // php/validate.php can be called from any page that requires user validation.
    // that page should POST the token to this script.
    // the token will be validated here.
    // then it will send the validation result to the calling page.

    // this call returns JSON objects.
    header("Content-Type: application/json");

    require_once("userAuthenticator.php");

    // run main
    main();


    // helper functions below ~~

    function main() {
        // main function, does the work
        $result = [];
        $result["data"] = null;
        $result["meta"] = null;

        if (isSet($_POST["token"])) {
            // resume the session to check saved token
            session_start();
            $token = $_POST["token"];

            if (isSet($_SESSION["loggedIn"])
                && isSet($_SESSION["token"])
                && $token == $_SESSION["token"]) {

                $isValidToken = UserAuthenticator::isValidToken($token);

                // set the user type and success
                if ($isValidToken) {
                    // get the user type
                    $userType = UserAuthenticator::getUserType($token);

                    // init the session
                    $_SESSION["token"] = $token;
                    $_SESSION["userType"] = $userType;

                    // place results in the return obj
                    $meta = [];
                    $meta["success"] = true;
                    $meta["code"] = 200;

                    $result["meta"] = $meta;

                    $data = [];
                    $data["token"] = $token;
                    $data["userType"] = $userType;

                    $result["data"] = $data;

                } else { // token matches session token but not valid
                    $meta = [];
                    $meta["success"] = false;
                    $meta["code"] = 401;
                    $meta["errorType"] = "Unauthorized";
                    $meta["errorMessage"] = "Token is invalid.";

                    $result["meta"] = $meta;
                }

            } else { // token does not match session token
                $meta = [];
                $meta["success"] = false;
                $meta["code"] = 401;
                $meta["errorType"] = "Unauthorized";
                $meta["errorMessage"] = "Token does not match the session token, or user is not logged in.";

                $result["meta"] = $meta;
            }

        } else { // no token given
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
