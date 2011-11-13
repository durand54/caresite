<?php
/*$json = $_POST['json']; // $json is a string
$person = json_decode($json); // $person is an array with a key 'name'
echo $person;*/
$mail = $_POST['email'];
$return['msg'] = $mail;
echo json_encode($return);
?>