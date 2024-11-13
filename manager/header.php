<?php
if(!defined("head")) {die("Wrong Access");
}
@session_start();
setcookie('number','',-1);
setcookie('type','',-1);
define('currentpage','admin');
define('admin',true);
define('pageid','81');
define('moduledir','../module/');
define('news_security',true);
// Include Files
include("../includes/db.php");
include("../includes/db.config.php");
if($config['adisable'] == '1'){//die();
}
include("../includes/template.php");
include("../includes/function.php");
require("../includes/user.php");
require("../includes/times.php");
require("../includes/html.php");


$tpl = new Rashcms();
$Themedir = "../template/admin/".$config['admintheme'].'/';
$tpl-> load($Themedir.$pageTheme);
$user = new user();
$permissions = $user->permission();
if(!$user->checklogin()){header("LOCATION: login.php");
die("Please Login...");exit;
}
$ip = safe(getRealIpAddr());
if($d->getrows("SELECT `ip` FROM `bann` WHERE `ip`='$ip' LIMIT 1",true) > 0)
	{
	$msg = $d->GetRowValue("mess","SELECT `mess` FROM `bann` WHERE `ip`='$ip' LIMIT 1",true);
	if(!isset($html))
	{
	require_once("../includes/html.php");
	$html = new html();
	}
	$html->msg($msg,'error');
	$html->printout(true);
	HEADER("LOCATION: ../banned.php");
	die();
	}
$config['site'] = substr($config['site'],-1) != '/' ? $config['site'].'/' : $config['site'];
$info = $user->info;
$tpl->assign(array(
'sitetitle'=>$config['sitetitle'],
'todayfarsi'=>cutime,
'messages'=>0,
'updates'=>0,
'fullname'=>$info['name'],
'usercolor'=>$info['color'],
'ip'	=> $ip,
'site'=>$config['site'],
));
if( (isset($permissions[page]) && @$permissions[page]!='1'  && page!='index') OR ($permissions['access_admin_area'] != '1'))
{$html = new html();
$html->msg($lang['waccess']);
$html->printout(true);
}
$q = $d->Query("SELECT * FROM `menus` order by `oid`");

while($data = $d->fetch($q))
{if(@$permissions[$data['name']]== '1' || $data['type']=='0' || $data['type']=='2')
{$target = ($data['type']== '2') ? '_blank' : '_self';
$class  = ($data['type']== '2') ? 'rashcms': 'rash';
if(page==$data['name']){$class  = ($class== 'rashcms') ? 'rashcms bold': 'rash bold';
}$tpl->block("rashcms_links",array(
'title'=>$data['title'],
'url'=>$data['url'],
'target'=>$target,
'class'=>$class,
));
}
}
?>