<?php
define('head',true);
define('page','member');
$pageTheme ='member.htm';
include('header.php');
$html = new html();
$html->ts('active_reg',$config['new_member'],2);
$html->ts('user_list',$config['user_list'],3);
$html->ts('min_user_len',$config['min_user_length'],5,4);
$html->ts('min_pass_len',$config['min_pass_length'],5,5);
$html->ts('allow_send_pm',$config['send_pm'],2);
$html->ts('allow_send_post',$config['send_post'],2);
$page = (is_numeric(@$_GET['page'])) ? $_GET['page'] : '0';$tpl->assign('page',$page);
$page = ($page != '0') ? $tpl->block('page',array()) : '';
$tpl->showit();
?>