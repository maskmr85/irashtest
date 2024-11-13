<?php
define('head',true);
define('page','block');
$pageTheme ='block.htm';
include('header.php');
	if(is_numeric(@$_GET['moveup']))
	{	$tpl->block('move',array());
	$qu = $d->Query("SELECT `order`,`id` FROM `block` WHERE `order`<'{$_GET['moveup']}'  ORDER BY `order` DESC LIMIT 1");
	$qu = $d->fetch($qu);
	$lowerid = $qu['id'];
	$qu = $qu['order'];
	 if(!empty($qu)){
 	 $d->Query("UPDATE `block` SET `order`='$qu' WHERE `order`='{$_GET['moveup']}'  LIMIT 1");
	 $d->Query("UPDATE `block` SET `order`='{$_GET['moveup']}' WHERE `id`='$lowerid' LIMIT 1");
	 }
	}elseif(is_numeric(@$_GET['movedown']))
	{	$tpl->block('move',array());
	$qu = $d->Query("SELECT `order`,`id` FROM `block` WHERE `order`>'{$_GET['movedown']}' ORDER BY `order` ASC LIMIT 1");
	$qu = $d->fetch($qu);
	$uperid = $qu['id'];
	$qu = $qu['order'];
	 if(!empty($qu)){
 	 $d->Query("UPDATE `block` SET `order`='$qu' WHERE `order`='{$_GET['movedown']}' LIMIT 1");
	 $d->Query("UPDATE `block` SET `order`='{$_GET['movedown']}' WHERE `id`='$uperid' LIMIT 1");
	}
	}
	$q = $d->Query("SELECT * FROM `module`");
	while($data = $d->fetch($q))
	$tpl->block('modules',array(
	'title'=>$data['title'],
	'name'=>$data['name'],
	'id'=>$data['id'],
	));
$tpl->showit();
?>