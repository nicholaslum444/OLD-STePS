<?php

	header("Content-Type: application/json");

	if (isSet($_POST["cmd"])) {
		echo json_encode($_POST);
	} else {
		echo "\$_POST[cmd] not set";
	}

?>
