<?php
define('rashcmsper','template');
define("ajax_head",true);
require("ajax_head.php");
function ptintpm($msg = 'waccess',$type = 'error'){
$html = new html();
global $lang;
$html->msg($lang[$msg],$type);
$html->printout(true);
}
$task = (!isset($_POST['task'])) ? ptintpm() : $_POST['task'];
switch ($task){case "main":
$id   =  (empty($_POST['id'])) ? ptintpm("allneed") : $_POST['id'];
$q = $d->Query("UPDATE `setting` SET `theme`='$id'");
ptintpm("ok","success");
break;
case "admin":
$id   =  (empty($_POST['id'])) ? ptintpm("allneed") : $_POST['id'];
$q = $d->Query("UPDATE `setting` SET `admintheme`='$id'");
ptintpm("ok","success");
break;
default:
ptintpm();
}
?>