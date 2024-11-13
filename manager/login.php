<?php
@session_start();
define('currentpage','admin');
define('pageid','81');
define('news_security',true);
// Include Files
//include('header.php');
include("../includes/db.php");
include("../includes/db.config.php");
include("../includes/template.php");
include("../includes/function.php");
require("../includes/user.php");
$Themedir = "../template/admin/".$config['admintheme'].'/';
$pageTheme ='login.htm';
$tpl = new Rashcms();
$tpl-> load($Themedir.$pageTheme);
$tpl->assign('rand',rand(1,5000000));
$user = new user();

if(isset($_POST['submit']))
{
if($user->checkimg(@$_POST['img'],$config['tries'])){
if($user->login($_POST['username'],$_POST['password'])){
HEADER("LOCATION: index.php");die();
}else{
$tpl->block('ifmsg',array('msg'=>$lang['wup']));}
$_SESSION['tries'] = intval(@$_SESSION['tries'])+1;
}else{
$tpl->block('ifmsg',array('msg'=>$lang['wrongseccode']));
$_SESSION['tries'] = intval(@$_SESSION['tries'])+1;
}
}
if(@$_SESSION['tries'] >= $config['tries'])
$tpl->block('ifsec',array());

if(isset($_GET['logout'])){
$user->logout();
}
$tpl->showit();

?>