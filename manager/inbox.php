<?php
define('head',true);
define('page','inbox');
$pageTheme ='inbox.htm';
include('header.php');
$page = (is_numeric(@$_GET['page'])) ? $_GET['page'] : '0';
$task = '';
if(isset($_GET['task']))
$task = $_GET['task'];
if($task == 'inbox'){
$tpl->assign('opage',0);
$page = ($page != '0') ? $tpl->block('inbox',array()) : '';
}elseif($task == 'outbox'){
$tpl->assign('opage',$page);
$tpl->assign('ipage',0);
$page = ($page != '0') ? $tpl->block('outbox',array()) : '';
}else{
$tpl->assign('ipage',0);
}
$tpl->showit();
?>