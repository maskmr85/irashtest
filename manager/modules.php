<?php
define('head',true);
define('page','module');
$pageTheme ='modules.htm';
include('header.php');
$error = '';
$module = (empty($_GET['module'])) ? die('RashCMS:: Invalid module name') : safeurl($_GET['module']);
$task = (empty($_GET['task'])) ? 'none' : $_GET['task'];
$information = array(
'name'			=>$lang['unknown'],
'provider'		=>$lang['unknown'],
'providerurl'	=>$lang['unknown'],
'install'		=>false,
'uninstall'		=>false,
'activate'		=>false,
'inactivate'	=>false,
);
define('module_admin_area',true);
define('actions',true);
if(!is_dir('../module/'.$module))
	$error = $lang['module']['wmodule'];
else
if(!is_file('../module/'.$module.'/admin-config.php'))
$error = $lang['module']['invalid'];
else
require('../module/'.$module.'/admin-config.php');
if(empty($error))
switch($task) {
case 'install':
if(isset($information['install']))
	{
		if($information['install'])
			{
				if(function_exists('installop'))
					installop();
				else
				$error = $lang['module']['invalid'];
			}
			else
			$error = $lang['module']['ioperation'];
	}
	else
	$error = $lang['module']['invalid'];
break;
case 'uninstall';
if(isset($information['uninstall']))
	{
		if($information['uninstall'])
			{
				if(function_exists('uninstallop'))
					uninstallop();
				else
				$error = $lang['module']['invalid'];
			}
			else
			$error = $lang['module']['ioperation'];
	}
	else
	$error = $lang['module']['invalid'];
break;
case 'activate';
if(isset($information['activate']))
	{
		if($information['activate'])
			{
				if(function_exists('activateop'))
					activateop();
				else
				$error = $lang['module']['invalid'];
			}
			else
			$error = $lang['module']['ioperation'];
	}
	else
	$error = $lang['module']['invalid'];
break;
case 'inactivate';
if(isset($information['inactivate']))
	{
		if($information['inactivate'])
			{
				if(function_exists('inactivateop'))
					inactivateop();
				else
				$error = $lang['module']['invalid'];
			}
			else
			$error = $lang['module']['ioperation'];

	}
	else
	$error = $lang['module']['invalid'];
break;
case 'none':
if(function_exists('defaultop'))
	defaultop();
		else
			$error = $lang['module']['invalid'];
break;
default :
@HEADER("LOCATION : module.php");
die($lang['module']['invalid']);
}
if(!empty($error))
$tpl->assign(array(
'module_name' 	=> $information['name'],
'Error'			=>1,
'msg' 			=> $error,
'first'			=>'',
));
$tpl->showit();
?>