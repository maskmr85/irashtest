﻿<?php
if(!defined('module_admin_area'))
die('invalid access');
if(!isset($permissions['access_admin_area']))
die('invalid access');
if($permissions['access_admin_area'] != '1')
die('invalid access');		
$information = array(
'name'			=>'نويسندگان',
'provider'		=>'رضا شاهرخيان',
'providerurl'	=>'http://rashcms.com',
'install'		=>false,
'uninstall'		=>false,
'activate'		=>true,
'inactivate'	=>true,
);
$tpl->assign('first','');
if(defined('actions'))
{
function defaultop()
{
print_msg('براي اين ماژول تنظيم خاصي در نظر گرفته نشده است.<br>براي فعال/غير فعال سازي ماژول مي توانيد از بخش "ماژول ها" اقدام كنيد.','Info');
}
function inactivateop()
{
global $d;
$d->Query("UPDATE `module` SET `stat`='0' WHERE `name`='author' LIMIT 1");
print_msg('ماژول با موفقيت غير فعال شد.','Success');
}
function activateop()
{
global $d;
$d->Query("UPDATE `module` SET `stat`='1' WHERE `name`='author' LIMIT 1");
print_msg('ماژول با موفقيت فعال شد.','Success');
}
function print_msg($msg,$type)
{
global $tpl,$information;
$tpl->assign(array(
'module_name' 	=> $information['name'],
$type			=>1,
'msg' 			=> $msg,
));
}
}
?>