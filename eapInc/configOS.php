<?php
ini_set('display_errors','On');

//call $BACKUP_PATH
require_once('path.php');
require_once('Database.php');

//call database
$ini_array = parse_ini_file(BACKUP_PATH."/db.ini");
//call salt
require_once(BACKUP_PATH."/salt.php");


//print_r(error_get_last());
//Date in the past
header("Expire: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header('Pragma: no-cache');
putenv('TZ=America/Los_Angeles');
header('Expires: ' . gmdate(DATE_RFC1123, time()-1));

$host = $ini_array['host'];
$dbPass = $ini_array['password'];
$dbUser = $ini_array['username'];
$dbName = $ini_array['database'];

$d = array(
        'host' => $host, 
        'user' => $dbUser, 
        'password' => $dbPass, 
        'name' => $dbName
    );
$db = new Database($d);
$entrydate = date("Y-m-d");

?>