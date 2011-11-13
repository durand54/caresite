<?php
//ini_set('display_errors','On');

/*
**insuring that there are no sessions set
*/
session_start();
/*if(isset($_SESSION['admin_id'])){
echo 'THIS IS SESSION ADMIN '.$_SESSION['admin_id'];
} else {
$sessionName = session_id();
$sessionCookie = session_get_cookie_params();
function logoutIndex(){
    $_SESSION = array(); 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_unset();
    session_destroy();
}

logoutIndex();
}*/
//echo 'THIS IS SESSION ADMIN '.$_SESSION['admin_id'];
/*
**end of session killer
*/

date_default_timezone_set('America/Los_Angeles');

require_once('adminInc/configOS.php');


require_once('configuration.php');
require_once('includeAdmin/html.php');
require_once('includeAdmin/system.php');
require_once('includeAdmin/db.php');
require_once('includeAdmin/front.php');
require_once('language/english.php');

define('_VALID_PAGE',1);
$admin_site_path=$admin_site_path;
$admin_live_site=$admin_site_path;
$images_path = 'http://eap.rcomcreative.com/img/';
db::init();



$home='home';
//   echo $_GET['comp'];
//   echo $_GET['task'];
$component=html::getInput($_GET,'comp','content');
$system= new system;
session::initAdmin();
front::initAdmin();
$system->site_path=$admin_site_path;
$system->live_site_path=$admin_live_site;
$system->breadcrumbs['Home']='index.php';
$system->setComponent($component);
$system->getTemplate();

//echo  $system->querys;
?>
