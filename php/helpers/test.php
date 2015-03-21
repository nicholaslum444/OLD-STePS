<?php
/**
 * Created by IntelliJ IDEA.
 * User: nick
 * Date: 3/21/15
 * Time: 1:27 PM
 */

require_once("userAuthenticator.php");


header("Content-Type: application/json");

$token = $_POST["token"];

echo json_encode(UserAuthenticator::getUserID($token));

?>