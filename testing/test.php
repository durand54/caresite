<?php
$ar1 = array("color" => array("favorite" => "red"), 5);
$ar2 = array(10, "color" => array("favorite" => "green", "blue"));
$result = array_merge_recursive($ar1, $ar2);
print_r($result);

$a1 = array("1987"=>array("1987"),"1988"=>array("1988"));
$a2 = array("1987"=>array("1988","text here"),"1932");
$result = array_merge_recursive($a1,$a2);
echo "<br /><br />";
print_r($result);
$string = "1984 New Entry GMT805";
$result = substr($string, 4);
$r = substr($string,0,4);
echo "$result $r";
?>