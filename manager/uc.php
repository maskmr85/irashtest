<?php
define('head',true);
define('page','uc');
$pageTheme ='upload.htm';
include('header.php');
$html = new html();
$html->ts('one',$config['random_name'],2);
$tpl->assign(array(
'formats'	=>	$config['allow_types'],
'one'		=>	$config['max_file_size'],
'total'		=>	$config['max_combined_size'],
'nums'		=>	$config['file_uploads'],
'dir'		=>	$config['dir'],
));
for($i=0;$i<$config['file_uploads'];$i++)
$tpl->block('numfiles',array());
$tpl->showit();
?>