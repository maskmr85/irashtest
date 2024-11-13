<?php
if(!defined("head")) {die("RashCMS::Wrong Access");
}
@session_start();
define('currentpage','main');
define('pageid','11');
define('news_security',true);
// Include Files
include("includes/db.php");
include("includes/db.config.php");
if($config['disable'] == '1'){
require("includes/html.php");
$html = new html();
$html->msg($lang["sitedisabled"]);
$html->printout(true);}

include("includes/template.php");
include("includes/function.php");
function safemini(&$value,$key){
$value = (preg_match('/^text_/',$key)) ?  safe($value,1) : safe($value);
return $value;
}
array_walk($_POST,'safemini');
array_walk($_GET,'safemini');
require("includes/user.php");

$ip = safe(getRealIpAddr());
if($d->getrows("SELECT `ip` FROM `bann` WHERE `ip`='$ip' LIMIT 1",true) > 0)
	{
	$msg = $d->GetRowValue("mess","SELECT `mess` FROM `bann` WHERE `ip`='$ip' LIMIT 1",true);
	if(!isset($html))
	{
	require_once("includes/html.php");
	$html = new html();
	}
	$html->msg($msg,'error');
	$html->printout(true);
	HEADER("LOCATION: banned.php");
	die($msg);
	}
$tpl = new Rashcms();
$Themedir = "template/main/".$config['theme'].'/';
$tpl-> load($Themedir.$pageTheme);
$user = new user();
if($login = $user->checklogin()){$info = $user->info;
$permissions = $user->permission();
}
if(isset($_POST['number']) && is_numeric(@$_POST['number']) && isset($_POST['type']) && !isset($_GET['reset'])){
	$_COOKIE['number'] = $RPP  = ($_POST['number'] >100)? 100 : $_POST['number'];
	$_COOKIE['type'] = $type = ($_POST['type'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else
	{
	$_COOKIE['number'] = $RPP = (!isset($_COOKIE['number']) || !is_numeric(@$_COOKIE['number']) || isset($_GET['reset'])) ? $config['num'] : $_COOKIE['number'];
	$_COOKIE['type'] = $type = (@$_COOKIE['type'] == 'ASC' || isset($_GET['reset'])) ? 'ASC' : 'DESC';
	}
	setcookie('number',$RPP);
	setcookie('type',$type);
	$CurrentPage = (!isset($_GET['page']) || !is_numeric(@$_GET['page']) || (abs(@$_GET['page']) == 0)) ? 1 : abs($_GET['page']);
	$From = ($CurrentPage-1)*$RPP;
	$login = ($config['member_area'] == '1') ? $user->checklogin() : false;
	$config['site'] = substr($config['site'],-1) != '/' ? $config['site'].'/' : $config['site'];
if(!defined('noblock'))
require("includes/mainblock.php");
$tpl->assign(array(
'sitetitle'=>$config['sitetitle'],
'todayfarsi'=>cutime,
'ip'	=> @$_SERVER['REMOTE_ADDR'],
'site'=>$config['site'],
'footer'=>$footer,
));
?>