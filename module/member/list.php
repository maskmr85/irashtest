<?php
if(!defined('Module-inc') OR !is_array(@$data))
die('<a href="http://help.rashcms.com/modules" target=_blank>RashCMS</a> :: Invalid calling of '.basename (__FILE__));
$itpl = new Rashcms();
$itpl-> load('module/member/list.html');
include('lang.fa.php');
$show_posts = false;
if($config['user_list'] == '1')
$error = $lang['disabled'];
elseif($config['user_list'] == '3' && !$login)
$error = $lang['limited_area'];
if(!empty($error))
$itpl->assign(array('Error'=>1,'ErrorMsg'=>$error));
else
{
$itpl->assign('Listing',1);
@$type = ($type !='DESC' && $type != 'ASC') ? 'ASC' : $type;
@$From = (!is_numeric($From)) ? 1 : abs($From);
@$RPP = (!is_numeric($RPP)) ? 10 : abs($RPP);
@$CurrentPage = (!is_numeric($RPP)) ? 1 : abs($CurrentPage);
$q = $d->Query("SELECT * FROM `member` ORDER BY `date` $type LIMIT $From,$RPP");
$tpl->assign('Page',1);
while($data = $d->fetch($q))
$itpl->block('users',array(
'name'=>$name,
'user'=>$data['user'],
'date'=>mytime($config['dtype'],$data['date'],$config['dzone']),
));
}
if(!isset($counter['member']))
$t_mem = $d->getrows("SELECT `u_id` FROM member",true);
else
$t_mem = $counter['member'];
rashpage($t_mem,$RPP,5,$CurrentPage,$tpl,'pages','index.php?module=member&action=list&');
$tpl -> block('Rsh',  array(
			'subject'	=> $config['sitetitle'],
			'sub_id'	=> 1,
			'sub_link'	=> 'index.php',
			'link'  	=> 'index.php?module=member',
			'title' 	=> $lang_register['member_list'],
			'body'  	=> $itpl->dontshowit(),
			)
			);

?>