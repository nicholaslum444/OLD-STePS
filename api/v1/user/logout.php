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
    $result["data"] = new stdClass();
    $result["meta"] = new stdClass();

    // will destroy session regardless
    session_start();
    session_unset();
    session_destroy();

    $meta = [];
    $meta["success"] = true;
    $meta["code"] = 200;

    $result["meta"] = $meta;

    $data = new stdClass();

    $result["data"] = $data;

    echo json_encode($result);

}

?>
