<?php
define('rashcmsper','cat');
define("ajax_head",true);
require("ajax_head.php");
require("../../includes/template.php");
$Themedir = "../../template/admin/".$config['admintheme'].'/ajax/';
$pageTheme ='quickcat.htm';
$tpl = new Rashcms();
$tpl-> load($Themedir.$pageTheme);
$q = $d->query("SELECT * FROM `cat` WHERE `sub`='0'");
	while ($data = $d->fetch($q)){
    $tpl->block("listtr",array("font"=>"bold","color"=>"green","Subject"=>$data['name'],"Ename"=>$data['enname'],"CatId"=>$data['id'],"CatMainId"=>"0"));
    $id = $data['id'];
    $qu = $d->query("SELECT * FROM `cat` WHERE `sub`='$id'");
    while ($datau = $d->fetch($qu)){    $tpl->block("listtr",array("font"=>"normal","color"=>"black","Subject"=>$datau['name'],"Ename"=>$datau['enname'],"CatId"=>$datau['id'],"CatMainId"=>$data['id']));
    $last = $datau["enname"];
	}

    }
    $tpl->showit();
?>