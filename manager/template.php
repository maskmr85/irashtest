<?php
define('head',true);
define('page','template');
$pageTheme ='template.htm';
include('header.php');
$html = new html();
$handle=opendir('../template/main');
    $themelist='';
    while ($file = readdir($handle)) {
    if (!ereg("[.]",$file)) {
    $themelist .= "$file{rashcms_/?.com}";

    }
    }
    closedir($handle);
    $themelist = explode("{rashcms_/?.com}", $themelist);
    sort($themelist);
    for ($i=0; $i < sizeof($themelist); $i++) {
    if(!empty($themelist[$i])) {    	$tpl->block('themelist',array(
		'theme_name'=>$themelist[$i],
		'theme_dir'=>$themelist[$i],
		));
    }
    }

    $handle=opendir('../template/admin');
    $themelist='';
    while ($file = readdir($handle)) {
    if (!ereg("[.]",$file)) {
    $themelist .= "$file{rashcms_/?.com}";

    }
    }
    closedir($handle);
    $themelist = explode("{rashcms_/?.com}", $themelist);
    sort($themelist);
    for ($i=0; $i < sizeof($themelist); $i++) {

    if(!empty($themelist[$i])) {
    	$tpl->block('admin_themelist',array(
		'theme_name'=>$themelist[$i],
		'theme_dir'=>$themelist[$i],
		));
    }
    }

$tpl->showit();
?>