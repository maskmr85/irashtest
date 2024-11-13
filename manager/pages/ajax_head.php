<?php
if(!defined("ajax_head")) {
die("Wrong Access");
}
@session_start();
define('currentpage','ajaxadmin');
define('updir','uploads');
define('news_security',true);
require("../../includes/db.php");
require("../../includes/db.config.php");
require("../../includes/function.php");
require("../../includes/html.php");
require("../../includes/user.php");
$ip = safe(getRealIpAddr());
if($d->getrows("SELECT `ip` FROM `bann` WHERE `ip`='$ip' LIMIT 1",true) > 0)
	{
	$msg = $d->GetRowValue("mess","SELECT `mess` FROM `bann` WHERE `ip`='$ip' LIMIT 1",true);
	$html->msg($msg,'error');
	$html->printout(true);
	HEADER("LOCATION: banned.php");
	die();
	}
if(defined('template')){require("../../includes/template.php");
$Themedir = "../../template/admin/".$config['admintheme'].'/ajax/';
$pageTheme = template;
$tpl = new Rashcms();
$tpl-> load($Themedir.$pageTheme);
}
if(defined('mpage')){if(isset($_POST['number']) && is_numeric(@$_POST['number']) && isset($_POST['type']) && !isset($_GET['reset'])){
	$_COOKIE['number'] = $RPP  = ($_POST['number'] >100)? 100 : $_POST['number'];
	$_COOKIE['type'] = $type = ($_POST['type'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else
	{
	$_COOKIE['number'] = $RPP = (!isset($_COOKIE['number']) || !is_numeric(@$_COOKIE['number']) || isset($_GET['reset'])) ? 10 : $_COOKIE['number'];
	$_COOKIE['type'] = $type = (@$_COOKIE['type'] == 'ASC' || isset($_GET['reset'])) ? 'ASC' : 'DESC';
	}
	setcookie('number',$RPP);
	setcookie('type',$type);
	$CurrentPage = (!isset($_POST['page']) || !is_numeric(@$_POST['page']) || (abs(@$_POST['page']) == 0)) ? 1 : abs($_POST['page']);
	$From = ($CurrentPage-1)*$RPP;
}
$user = new user();
$html = new html();
$info = $user->info;
function safemini(&$value,$key){
 if($key == 'rezash_text' || $key == 'rezash_full_text' || $key == 'context' || $key == 'text')
 $value = safe($value,1);
 else
 $value = safe($value);
 return $value;
}
array_walk($_POST,'ajaxvars');
array_walk($_POST,'safemini');
 if(!$user->checklogin()){
 $html->msg($lang['ajaxlogin']);
 $html->printout();
 }
 $info = $user->info;
 $permissions = $user->permission();
 $permissions['allow'] = 1;
 if(isset($permissions[rashcmsper]))
 if($permissions[rashcmsper] == 0)
 { $html->msg($lang['waccess'],'error');
 $html->printout(true); }

?>