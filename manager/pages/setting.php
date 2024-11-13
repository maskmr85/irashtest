<?php
define('rashcmsper','setting');
define("ajax_head",true);
require("ajax_head.php");
function printpm($msg = 'waccess',$type = 'error'){
$html = new html();
global $lang;
$html->msg($lang[$msg],$type);
$html->printout(true);
}
$task = (!isset($_POST['task'])) ? printpm() : $_POST['task'];
switch ($task){case "general":

$email 		=  (empty($_POST['email'])) 		? printpm("allneed") : $_POST['email'];
$site   	=  (empty($_POST['site'])) 			? printpm("allneed") : $_POST['site'];
$tries 		=  (!is_numeric($_POST['tries'])) 	? printpm() : $_POST['tries'];
$num 		=  (!is_numeric($_POST['num'])) 	? printpm() : $_POST['num'];
$num 		=  ($num>15) ? 15 : $num;
$nlast 		=  (!is_numeric($_POST['nlast'])) 	? printpm() : $_POST['nlast'];
$nlast 		=  ($nlast>25) ? 25 : $nlast;
$member 	=  (!is_numeric($_POST['member_area'])) 	? printpm() : $_POST['member_area'];
$member 	=  ($member!=1 && $member!=2) ? printpm() : $member;
$comment 	=  (!is_numeric($_POST['comment'])) 	? printpm() : $_POST['comment'];
$comment 	=  ($comment!=1 && $comment!=2 && $comment!=3 && $comment!=4) ? printpm() : $comment;

$q = $d->uquery("setting",array(
'site'=>$site,
'email'=>$email,
'num'=>$num,
'nlast'=>$nlast,
'tries'=>$tries,
'member'=>$member,
'comment'=>$comment,
));
printpm("ok","success");
break;

case "time":
$dzone 	=  (empty($_POST['dzone'])) ? printpm("allneed") : $_POST['dzone'];
$dtype  =  (empty($_POST['dtype'])) ? printpm("allneed") : $_POST['dtype'];
$d->uquery("setting",array("dzone"=>$dzone,"dtype"=>$dtype));
printpm("ok","success");
break;
case "seo":
$title 	=  (empty($_POST['title']))? printpm("allneed") : $_POST['title'];
$keys   =  (empty($_POST['keys'])) ? printpm("allneed") : $_POST['keys'];
$desc   =  (empty($_POST['desc'])) ? printpm("allneed") : $_POST['desc'];
$seo 	=  ($_POST['seo']!='1' && $_POST['seo']!='2' ) ? printpm() : $_POST['seo'];
$q = $d->uquery("setting",array(
'sitetitle'=>$title,
'keys'=>$keys,
'desc'=>$desc,
'seo'=>$seo,
));
printpm("ok","success");
break;
case "menus":
$list 	=  (empty($_POST['list'])) ? printpm() : explode(",",$_POST['list']);
$c = 0;
foreach($list as $i)
{if(is_numeric($i))$d->Query("UPDATE `menus` SET `oid`='$c' WHERE `id`='$i' LIMIT 1");
$c++;
}
printpm("ok","success");
break;
default:
printpm();
}
?>