<?php

    // php/logout.php should be called by the logout button (on any page).
    // this script will end the current user's session.
    // that page should POST the auth token to this script.
    // even though i'm not processing the token now, it might still be useful.

    // this call returns JSON objects.
    header("Content-Type: application/json");

    // run main
    main();


    // helper functions below ~~

    function main() {
        // main function, does the work
        $result = [];
        $result["success"] = true;
        $result["data"] = null;
        $result["comments"] = null;

        // will destroy session regardless
        session_start();
        session_unset();
        session_destroy();

        echo json_encode($result);

    }

?>
