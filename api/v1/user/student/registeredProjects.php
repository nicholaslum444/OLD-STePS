<?php

// this call returns JSON objects.
header("Content-Type: application/json");\

// require_once("dbmanager.php");

main();

/**
 *  Main function
 */
function main() {
    // main function, does the work
    $result = [];
    $result["data"] = new stdClass();
    $result["meta"] = new stdClass();

    session_start();

    if (isset($_GET["token"]) && isset($_SESSION["token"])) {
        $sessionToken = $_SESSION["token"];
        $userToken = $_GET["token"];
        if ($sessionToken == $userToken && $_SESSION["userType"] == "student") {
            // "authenticated" as student
            // carry out the actions of getting modules
            if (isset($_GET["iteration"])) {
                //$dbManager = new DatabaseManager();

                $iteration = $_GET["iteration"];
                $studentID = $_SESSION["studentID"];
                $data = [];
                $data["iteration"] = $iteration;
                //$data["projects"] = dbManager.getRegisteredProjects($studentID, $iteration);
                // TODO replace with acutal db function when ready
                $data["projects"] = makeDummyProjects($studentID, $iteration);

                $result["data"] = $data;

                $meta = [];
                $meta["success"] = true;
                $meta["code"] = 200;

                $result["meta"] = $meta;

            } else { // no iteration given
                // bad request, please give which iteration
                $meta = [];
                $meta["success"] = false;
                $meta["code"] = 400;
                $meta["errorType"] = "Bad Request";
                $meta["errorMessage"] = "STePS iteration not specified.";

                $result["meta"] = $meta;
            }

        } else { // token don't match, not authenticated
            // return authentication error
            $meta = [];
            $meta["success"] = false;
            $meta["code"] = 401;
            $meta["errorType"] = "Unauthorized";
            $meta["errorMessage"] = "Authentication failure.";

            $result["meta"] = $meta;
        }

    } else { // no token given or stored (assume not logged in?)
        // return authentication error
        $meta = [];
        $meta["success"] = false;
        $meta["code"] = 401;
        $meta["errorType"] = "Unauthorized";
        $meta["errorMessage"] = "Token not specified or user is not logged in.";

        $result["meta"] = $meta;
    }
}

function makeDummyProjects($studentID, $iteration) {
    $projects = [];

    $project1 = [];
    $project1["id"] = 1;
    $project1["moduleCode"] = "CS3202";
    $project1["title"] = "Retailytics";
    $project1["abstract"] = "This is the project abstract.";
    $project1["posterUrl"] = "http://facebook.com/photos/Retailytics.jpg";
    $project1["videoUrl"] = "http://facebook.com/videos/Retailytics.mp4";

    $members1 = [];
    $member1 = [];
    $member1["name"] = "Alice Lee";
    $member1["matric"] = "A1234567X";
    $members1[0] = $member1;
    $member2 = [];
    $member2["name"] = "Bob Lee";
    $member2["matric"] = "A1234568X";
    $members1[1] = $member2;

    $project1["members"] = $members1;

    $projects[0] = $project1;

    return $projects;
}

?>