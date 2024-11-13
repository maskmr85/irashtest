<?php
define('rashcmsper','cat');
define("ajax_head",true);
require("ajax_head.php");
function ptintpm($msg = 'waccess',$type = 'error'){
$html = new html();
global $lang;
$html->msg($lang[$msg],$type);
$html->printout(true);
}
$task = (!isset($_POST['task'])) ? ptintpm() : $_POST['task'];
switch ($task){case "addsubject":
$subject   =  (empty($_POST['subject'])) ? ptintpm("allneed") : $_POST['subject'];
$ensubject =  (empty($_POST['ensubject'])) ? ptintpm("allneed") : $_POST['ensubject'];
$q = $d->query("SELECT * FROM `cat` WHERE (`name`='$subject' OR `enname`='$ensubject') AND `sub`='0'");
if($d->getrows($q) > 0){ptintpm("cat_exists");
}
$q = $d->iquery("cat",array(
'sub'=>0,
'name'=>$subject,
'enname'=>$ensubject,
));
ptintpm("cat_created","success");
break;
case "add_sub_subject":
$sub_subject   =  (empty($_POST['sub_subject'])) ? ptintpm("allneed") : $_POST['sub_subject'];
$sub_ensubject =  (empty($_POST['sub_ensubject'])) ? ptintpm("allneed") : $_POST['sub_ensubject'];
$sub_main	   =  (!is_numeric(@$_POST['main'])) ? ptintpm() : $_POST['main'];
$q = $d->query("SELECT * FROM `cat` WHERE `id`='$sub_main'");
if($d->getrows($q) <= 0){ptintpm();
}
$q = $d->query("SELECT * FROM `cat` WHERE (`name`='$sub_subject' OR `enname`='$sub_ensubject') AND `sub`='$sub_main'");
if($d->getrows($q) > 0){
ptintpm("cat_exists");
}
$q = $d->iquery("cat",array(
'sub'=>$sub_main,
'name'=>$sub_subject,
'enname'=>$sub_ensubject,
));
ptintpm("cat_created","success");
break;
case "edit_subject":
$edit_sub   =  (empty($_POST['edit_sub'])) ? ptintpm("allneed") : $_POST['edit_sub'];
$edit_ensub =  (empty($_POST['edit_ensub'])) ? ptintpm("allneed") : $_POST['edit_ensub'];
$editing_id =  (!is_numeric(@$_POST['editing_id'])) ? ptintpm("allneed") : $_POST['editing_id'];
$main =  (!is_numeric(@$_POST['main'])) ? ptintpm("allneed") : $_POST['main'];
$qu = $d->Query("SELECT `sub` FROM `cat` WHERE `id`='$editing_id'");
$qu = $d->fetch($qu);
$sub = $qu['sub'];
if($sub == 0 && $main!=0){$qu = $d->Query("UPDATE `cat` SET `sub`='0' WHERE `sub`='$editing_id'");
$d->uquery("cat",array("name"=>$edit_sub,"enname"=>$edit_ensub,"sub"=>$main),"id=".$editing_id);
}else{$d->uquery("cat",array("name"=>$edit_sub,"enname"=>$edit_ensub,"sub"=>$main),"id=".$editing_id);
}
ptintpm("cat_edited","success");
break;
case "delete_subject":
$id =  (!is_numeric(@$_POST['id'])) ? ptintpm() : $_POST['id'];
$qu = $d->Query("SELECT `sub` FROM `cat` WHERE `id`='$id'");
$qu = $d->fetch($qu);
$sub = $qu['sub'];
if($sub == 0){
$qu = $d->Query("UPDATE `cat` SET `sub`='0' WHERE `sub`='$id'");
$qu = $d->Query("DELETE FROM `cat`  WHERE `id`='$id' LIMIT 1");
}else{$qu = $d->Query("DELETE FROM `cat`  WHERE `id`='$id' LIMIT 1");
$qu = $d->Query("SELECT `id` FROM `data`  WHERE `cat_id`='$id'");
while($q = $d->fetch($qu))
$qu = $d->Query("DELETE FROM `catpost`  WHERE `postid`='$q[id]'");
$qu = $d->Query("DELETE FROM `data` WHERE `cat_id`='$id'");
}
ptintpm("cat_deleted","success");
break;
case "listing":
$type = (@$_POST['type']!=1 AND @$_POST['type']!=2) ? ptintpm() : $_POST['type'];
$q = $d->query("SELECT id,name FROM `cat` WHERE `sub`='0'");
	$main = '';
	$main2 = '<option id="cat_list_0" value="0">'.$lang['mainsub'].'</option>';
	while ($data = mysql_fetch_array($q)){
        $main  .= '<option value="'.$data["id"].'">'.$data["name"].'</option>';
        $main2 .= '<option id="cat_list_'.$data["id"].'" value="'.$data["id"].'">'.$data["name"].'</option>';
    }
    $main = '<select class="select" name="emain" id="emain" size="1">'.$main.'</select>';
    $main2 = '<select class="select" id="main" name="main" size="1">'.$main2.'</select>';
$type = ($type == 1) ? die($main) : die($main2);
break;
default:
ptintpm();
}
?>