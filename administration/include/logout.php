<?php
	if (!isset($_SESSION["session"]["username"]) && !isset($_SESSION["session"]["password"]))
	{
		header ("Location: /index.php");
	} else
	{
		if (isset($_GET["action"]) && $_GET["action"] == "logout") {
			session_unset();
			header ("Location: /index.php");
			exit;
		}
	}
?>