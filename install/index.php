<?php
/***************************************************************************
 *                                  Rash CMS
 *                          -------------------
 *   copyright            : (C) 2009 The RashCMS  $Team = "www.rashcms.com";
 *   email                : info@rashcms.com
 *   email                : rashcms@gmail.com
 *   programmer           : Reza Shahrokhian
 ***************************************************************************/
session_start();
define('install',true);
//error_reporting('0');
define('news_security',true);
require('../includes/template.php');
require('lang.fa.php');
$r = @file_get_contents('rashcms.lock');
if($r == '1')
die('RashCMS:: Install is disabled !!');
$MyTpl = new RashCMS();
$MyTpl -> load( 'temp.html' );
$steps = array($lang['license'],$lang['requirement'],$lang['admindbc'],$lang['write_config']);
$steps_name = array('license','requirement','admindbc','write_config','code');
if(!isset($_SESSION['step']))
	$_SESSION['step'] = 'license';
elseif(!in_array($_SESSION['step'],$steps_name))
	$_SESSION['step'] = 'license';
define('green','<font color="green">');
define('red','<font color="red">');
define('endf','</font>');
if($_SESSION['step'] == 'license'){
if(!isset($_POST['accpet']))
$MyTpl -> assign('Agree',1);
else
$_SESSION['step'] = 'requirement';
}
if($_SESSION['step'] == 'requirement'){
if(isset($_POST['next']))
$_SESSION['step'] = 'admindbc';
else
{
if (@phpversion() < '4.1')
$MyTpl -> assign('phpver',red.phpversion().endf);
else
$MyTpl -> assign('phpver',green.phpversion().endf);
if (@extension_loaded('xml'))
$MyTpl -> assign('xml',green.$lang['support'].endf);
else
$MyTpl -> assign('xml',red.$lang['notsupport'].endf);
if(function_exists( 'mysql_connect' ))
$MyTpl -> assign('MySql',green.$lang['support'].endf);
else
$MyTpl -> assign('MySql',red.$lang['notsupport'].endf);

if (@file_exists('../includes/db.config.php') &&  @is_writable( '../includes/db.config.php' )){
$MyTpl -> assign('dbconfig',green.$lang['support'].endf);
$_SESSION['config'] = '1';
}else{
$MyTpl -> assign('dbconfig',red.$lang['notsupport'].endf.'<a href="javascript:void(\'0\');" onclick="alert(\''.$lang['confign'].'\');">'.$lang['moreinfo'].'</a>');
$_SESSION['config'] = 'unw';
}
$rsh_session_pass = ini_get( 'session.save_path' );
if (is_writable($rsh_session_pass)){
$MyTpl -> assign('session',green.$lang['support'].endf);
}else{
$MyTpl -> assign('session',red.$lang['notsupport'].endf.'<a href="javascript:void(\'0\');" onclick="alert(\''.$lang['smbwr'].'\');">'.$lang['moreinfo'].'</a>');
//$error = '1';
}
if ( ini_get('register_globals') == '1' ) {
$MyTpl -> assign('register_globals',red.$lang['rgb'].endf);
}else{
$MyTpl -> assign('register_globals','');
}
$MyTpl -> assign('Step_0',1);
//End OF step 0
}
}

//Start of step1
if($_SESSION['step'] == 'admindbc'){
if (empty($_POST['db_host']))
$MyTpl -> assign('Step_1',1);
else{
$username        = @$_POST['db_user'];
$password        = @$_POST['db_pass'];
$hostname        = @$_POST['db_host'];
$dbname          = @$_POST['db_name'];
$site            = @$_POST['site'];
$email           = @$_POST['email'];
$rashaction      = @$_POST['rashaction'];
$_SESSION['user'] = $username;
$_SESSION['pass'] = $password;
$_SESSION['host'] = $hostname;
$_SESSION['db']   = $dbname;
$_SESSION['url']  = $site;
$sql = @mysql_connect($hostname,$username,$password);
@mysql_query("SET CHARACTER SET utf8;");
@mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");
$database = @mysql_select_db($dbname,$sql);
if ((!$sql) or (!$database)) {
$MyTpl -> assign('Step_1',1);
$MyTpl -> assign('Error',1);
$MyTpl -> assign('Msg',$lang['cantcondb']);
}else{
if($rashaction == 'install'){
require('import.php');
}else{
//Start of update
require('uimport.php');
//End Of Update
}
$_SESSION['step'] = 'write_config';

//echo '<script language="javascript">document.location.href=\'index.php\';</script>';
}
}
//End of Step 1
}
if ($_SESSION['step'] =='write_config'){
if(isset($_POST['continue']))
$_SESSION['step'] = 'code';
else
{
$MyTpl -> assign('Step_2',1);
if(@$_SESSION['config'] == '1')
$MyTpl -> assign('Yconfig',1);
else
$MyTpl -> assign('Config',1);
$_SESSION['step3'] = '3';
//End of step 2
}
}
if ($_SESSION['step'] =='code'){

$username        = @$_SESSION['user'];
$password        = @$_SESSION['pass'];
$host            = @$_SESSION['host'];
$db              = @$_SESSION['db'];
$dbconfigstr="<?php
error_reporting('0');
if ( !defined('news_security'))
{
 die(\"You are not allowed to access this page directly!\");
}

\$dbconfig   = array(
'hostname'  => '".$host."',
'username'  => '".$username."',
'password'  => '".$password."',
'perfix'    => '',
'database'  => '".$db."'
);
\$perfix = \$dbconfig['perfix'];
//Select database

\$d = new dbclass();
\$d->mysql(\$dbconfig['hostname'],\$dbconfig['username'],\$dbconfig['password'],\$dbconfig['database']);
\$d->query(\"SET CHARACTER SET utf8;\");
\$d->query(\"SET SESSION collation_connection = 'utf8_general_ci'\");

\$config = \$d->Query(\"SELECT * FROM \$perfix.setting LIMIT 0,1\");
\$config =\$d->fetch(\$config);
function safeinturl(\$url){
return \$url;
}
if(!defined('rss')){
if(currentpage == 'admin')
{\$dir = '../';}elseif(currentpage == 'ajaxadmin'){\$dir = '../../';}else{\$dir = '';}
require(\$dir.\"includes/farsi.php\");
include(\$dir.\"includes/jdf.php\");
define('cutime',jdate('l j F Y'));
}
\$footer = '<a href=\"http://rashcms.com\" targe=_blank>:: RashCMS ::</a> - <a href=\"http://mihanphp.com\" targe=_blank>:: MihanPHP ::</a>';
?>";
$handles = @fopen('../includes/db.config.php', 'w+');
$successs = @fwrite($handles,$dbconfigstr);
@fclose($handle);
if((!$successs)){
$MyTpl -> assign('Config',1);
$MyTpl -> assign('config_text',$configstr);
$MyTpl -> assign('dbconfig_text',$dbconfigstr);
}else{
$handles = @fopen('rashcms.lock', 'w+');
$successs = @fwrite($handles,'1');
}
$alert ='<script language="javascript">alert("Delete install.php file immediately!\n www.rashcms.com \n www.forum.rashcms.com");</script>';
session_unset();
session_destroy();
$MyTpl -> assign('alert',$alert);
$MyTpl -> assign('step_name',$steps['3']);
$MyTpl -> assign('Step_3',1);
}
//End of step 3
$MyTpl -> showit();


?>