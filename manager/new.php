<?php
define("head",true);
define('page','newpost');
$pageTheme ='new.htm';
include('header.php');
	if(isset($permissions['newpost']))
	if($permissions['newpost'] != '1'){
	require('../include/html.php');
	$html = new html();
	$html->msg($lang['limited']);
	$html->printout('info');
	}
$q = $d->query("SELECT * FROM `cat`");
	$main ='';
	$mains ='';
	$mains_ajax = '';
	while ($data = $d->fetch($q)){
    if($data['sub'] == 0){
    $mains.='<optgroup label="&nbsp;'.$data['name'].'&nbsp;">';
    $id = $data['id'];
    $main.='<b>'.$data['name'].'</b><br>';
    $qu = $d->Query("SELECT * FROM `cat` WHERE `sub`='$id'");
    while ($datau = $d->fetch($qu)){
    $mains.='<option value="'.$datau["id"].'">&nbsp;&nbsp;'.$datau["name"].'&nbsp;&nbsp;</option>';
    $main.='<input  type="checkbox" name="'.$datau["enname"].'" id="'.$datau["enname"].'" value="'.$datau["id"].'" ><label for="'.$datau["enname"].'" class="hand">'.$datau["name"].'</label> <br>' ;
	$mains_ajax .="'".$datau["enname"]."',";
    $last = $datau["enname"];
	}
    $mains.='</optgroup>';
    }
    }
    $mains_ajax = str_replace($last."',",$last."'",$mains_ajax);
    $main .= '';
    $maine  = '<select name="main" id="main" class="inp">'.$mains;
    $rmain = ''.$main;

    $expiredate = timeboxgen('expiredate');
    $posttime   = timeboxgen('posttime');
    $tpl->assign(array(
    'main'=>$maine,
    'subject'=>$rmain,
    'expiredate'=>$expiredate,
    'posttime'=>$posttime,
    'cats_id'	=> $mains_ajax,
    ));
$tpl->showit();

?>