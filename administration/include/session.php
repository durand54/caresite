<?php
	// start the session
	session_start();
	// register the session array
	session_register("session");
	
	if (isset($_GET["action"]) && $_GET["action"] == "logout")
	{ // remove the session information
		session_unset();
	}
	
	if (isset($_POST["username"]) && isset($_POST["password"]))
	{
		$q = "SELECT id, username, password FROM Administrators WHERE username='$_POST[username]' AND password='$_POST[password]'";
		$qr= @mysql_query($q);
		if (@mysql_num_rows($qr) > 0)
		{
			$r = @mysql_fetch_array($qr);
			$_SESSION["session"]["id"] = $r["id"];
			$_SESSION["session"]["username"] = $r["username"];
			$_SESSION["session"]["password"] = $r["password"];
			header("Location: $_SERVER[PHP_SELF]");
		}
	}
	
?>