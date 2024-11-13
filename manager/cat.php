<?php
define('head',true);
define('page','cat');
$pageTheme ='cat.htm';
include('header.php');
$q = $d->query("SELECT id,name FROM `cat` WHERE `sub`='0'");
	$main = '';
	$main2 = '<option id="cat_list_0" value="0">'.$lang['mainsub'].'</option>';
	while ($data = mysql_fetch_array($q)){
        $main  .= '<option value="'.$data["id"].'">'.$data["name"].'</option>';
        $main2 .= '<option id="cat_list_'.$data["id"].'" value="'.$data["id"].'">'.$data["name"].'</option>';
    }
    $main = '<select class="select" name="emain" id="emain" size="1">'.$main.'</select>';
    $main2 = '<select class="select" id="main" name="main" size="1">'.$main2.'</select>';
$tpl->assign(array("main"=>$main,"main2"=>$main2));
$tpl->showit();
?>