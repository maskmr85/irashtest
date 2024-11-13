<?php
define('head',true);
define('page','module');
$pageTheme ='module.htm';
include('header.php');
$handle=opendir('../module');
define('module_admin_area',true);
    while ($file = readdir($handle)) {
    if (!ereg("[.]",$file)) {
	$file = safe($file);
		
		if(is_file('../module/'.$file.'/admin-config.php'))
		{
		if(isset($information))
		unset($information);
		$q = $d->getrows("SELECT `stat` FROM `module` WHERE `name`='$file' LIMIT 1",true);
		if($q > 0)
		$q = $d->getrowvalue("stat","SELECT `stat` FROM `module` WHERE `name`='$file' LIMIT 1",true);
		else
		$q = '-1';
		$stat = $lang['unknown'];
		if($q == '-1')
			$stat = $lang['uninstalled'];
		elseif($q == 0)
			$stat = $lang['inactive'];
		else
			$stat = $lang['active'];
		include('../module/'.safeurl($file).'/admin-config.php');
		
		$name = isset($information['name']) ? safe($information['name']) : $lang['unknown'];
		$provider = isset($information['provider']) ? safe($information['provider']) : $lang['unknown'];
		$url = isset($information['providerurl']) ? safe($information['providerurl']) : 'http://rashcms.com/';
		$arr = array(
		'name'=>$name,
		'provider'=>$provider,
		'url'=>$url,
		'stat'=>$stat,
		'file'=>$file,
		);
		if(isset($information['install']) && ($q == '-1')  )
			if($information['install'])
			{
			$arr['Install'] = 1;
			}
		if(isset($information['activate'])  && ($q == 0) && !(isset($arr['Install'])))
		if($information['activate'])
		$arr['Activate'] = 1;
		if(isset($information['uninstall']) && ($q != '-1'))
		if($information['uninstall'])
		$arr['UInstall'] = 1;
		if(isset($information['inactivate'])  && ($q != 0 && $q != '-1')  )
		if($information['inactivate'])
		$arr['InActivate'] = 1;
		$tpl->block('modulelist',$arr);
		}
    }
    }
    closedir($handle);
   
$tpl->showit();
?>