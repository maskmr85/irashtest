<?php
define("rashcmsper",'extra');
define("ajax_head",true);
require("ajax_head.php");
function ptintpm($msg = 'waccess',$type = 'error'){
$html = new html();
global $lang;
$html->msg($lang[$msg],$type);
$html->printout(true);
}
$task = (!isset($_POST['task'])) ? ptintpm() : $_POST['task'];
switch ($task){case "add_page":
$show 	  = array(1,2,3);
$show =  (!in_array(@$_POST['show'],$show)) ? ptintpm() : $_POST['show'];
$title =  (empty($_POST['title'])) ? ptintpm("allneed") : $_POST['title'];
$text =  (empty($_POST['rezash_text'])) ? ptintpm("allneed") : $_POST['rezash_text'];
$q = $d->iquery("extra",array(
'title'=>$title,
'users'=>$show,
'text'=>$text,
));
ptintpm("page_created","success");
break;

case "edit_page":
$show 	  = array(1,2,3);
$show =  (!in_array(@$_POST['show'],$show)) ? ptintpm() : $_POST['show'];
$title =  (empty($_POST['title'])) ? ptintpm("allneed") : $_POST['title'];
$text =  (empty($_POST['rezash_text'])) ? ptintpm("allneed") : $_POST['rezash_text'];
$id =  (!is_numeric(@$_POST['id'])) ? ptintpm() : $_POST['id'];
$q = $d->uquery("extra",array(
'title'=>$title,
'users'=>$show,
'text'=>$text,
),"id=".$id." LIMIT 1 ");
ptintpm("page_edited","success");
break;
case "delete_page":
$id =  (!is_numeric(@$_POST['id'])) ? ptintpm() : $_POST['id'];
$qu = $d->Query("DELETE FROM `extra`  WHERE `id`='$id' LIMIT 1");
ptintpm("page_deleted","success");
break;
default:
ptintpm();
}
?>