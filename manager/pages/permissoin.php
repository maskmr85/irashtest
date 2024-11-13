<?php
define('rashcmsper','permission');
define("ajax_head",true);
$pageTheme = 'quickper.htm';
define('template',$pageTheme);
require("ajax_head.php");
$id = (isset($_POST['user'])) ? $_POST['user'] : die("Invalid User!");
$cuser = new user($id);
if(!$cuser->exists(0,$id))
die("invalid user!");
$permissions = $cuser-> permission();
$q = $d->Query("SELECT * FROM `menus` WHERE `type`='1'");
while($data = $d->fetch($q)){	$stat = ($permissions[$data['name']]=='1') ? 1 : 2;
	$tpl->block("rashcms_per",array("id"=>$data['id'],"rash"=>$data['name'],"rashcms_name"=>$data['title']));
	$html->ts("rashcms_admin_".$data['id'],$stat,2);
}
$html->ts("rashcms_admin_acc",$permissions['access_admin_area'],2);
$tpl->assign("rashcms_usr_id",$id);
if($permissions['access_admin_area'] == 0){
$tpl->assign("admin_display","none");
$tpl->assign("rash_display","visible");
}else
{$tpl->block("rashcms_per",array("id"=>'rashcmscom',"rash"=>'editotherposts',"rashcms_name"=>$lang['editotherposts']));
$stat = ($permissions['editotherposts'] == 1) ? 1 : 2;
$html->ts("rashcms_admin_rashcmscom",$stat,2);
$tpl->assign("admin_display","visible");
$tpl->assign("rash_display","none");}
$tpl->showit();
?>