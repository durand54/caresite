<?php
	// connect to the database
	$db_connection = mysql_connect(DBHOST, DBUSERNAME, DBPASSWORD) or
		die ("Could Not Log On To The Database " . mysql_error());
	$db_select = mysql_select_db (DBNAME) or
		die ("Could not select the specified database. " . mysql_error());
?>