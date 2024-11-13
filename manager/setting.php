<?php
define('head',true);
define('page','setting');
$pageTheme ='setting.htm';
include('header.php');
$html = new html();
$tpl->assign(array(
'email'=>$config['email'],
'num'=>$config['num'],
'nlast'=>$config['nlast'],
'tries'=>$config['tries'],
'title'=>$config['sitetitle'],
'keys'=>$config['keys'],
'desc'=>$config['desc'],
));
$q = $d->Query("SELECT * FROM `menus` order by `oid`");
$id = '';
while($data = $d->fetch($q))
{$tpl->block("menu_name",array(
'name'=>$data['title'],
'id'=>$data['id'],
));
}
$html->ts('seo',$config['seo'],2);
$html->ts('active_reg',$config['new_member'],2);
$html->ts('user_list',$config['user_list'],3);
$html->ts('min_user_len',$config['min_user_length'],5,4);
$html->ts('min_pass_len',$config['min_pass_length'],5,5);
$html->ts('allow_send_pm',$config['send_pm'],2);
$html->ts('allow_send_post',$config['send_post'],2);
$html->ts('one',$config['random_name'],2);
$html->ts('member_area',$config['member'],2);
$html->ts('comment',$config['comment'],4);

$tpl->assign(array(
'formats'	=>	$config['allow_types'],
'one'		=>	$config['max_file_size'],
'total'		=>	$config['max_combined_size'],
'nums'		=>	$config['file_uploads'],
));
$tpl->showit();
?>