<?php
$pageTheme ='admin.htm';
define('crrentver','3.0.0.0');
define("head",true);
define('page','index');
include('header.php');
$q = $d->Query("SELECT * FROM `comments` ORDER by `date` LIMIT 10");
while($data = $d->fetch($q))
{
$qu = $d->Query("SELECT `title` FROM `data` WHERE `id`='{$data['p_id']}'");
$qu = $d->fetch($qu);
if($data['memberid'] != '-1'){
$sender_info = $user->info(false,$data['memberid']);
$sender_user = $sender_info['user'];
$sender_name = $lang['users']['member'];
}else{
$sender_user = 'guest';
$sender_name = $lang['users']['guest'];
}
$tpl->block("comment",array(
"id"=>$data['c_id'],
"postid"=>$data['p_id'],
"post"=>$qu['title'],
"email"=>$data['email'],
"name"=>$data['c_author'],
"site"=>$data['url'],
"member_name"=>$sender_name,
"member_user"=>$sender_user,
"comment_date"=>mytime($config['dtype'],$data['date'],$config['dzone']),
"comment"=>nl2br($data['text']),
));
}
$q = $d->Query("SELECT `stat` FROM `module` WHERE `name`='counter' lIMIT 1");
if($d->getrows($q) <= 0)
$tpl->assign('DisabledCounter',true);
else
	{
	$data = $d->fetch($q);
		if($data['stat'] == '3')
			$tpl->assign('DisabledCounter',true);
		else
		require_once(moduledir.'counter/count.php');
		if($data['stat'] == 1)
		{
		$tpl -> assign( array(
		'total_news'=>  $counter['totalpost'],
		'today'     =>  $counter['todayv'],
		'yes'       =>  $counter['yesterdayv'],
		'total'     =>  $counter['totalv'],
		'ons'       =>  $counter['onlines'],
		'month'     =>  $counter['monthv'],
		'pmonth'    =>  $counter['lastmonthv'],
		'year'      =>  $counter['yearv'],
		'pyear'     =>  $counter['lastyearv'],
		'tmem'      =>  $counter['member'],
		'ncom'      =>  $counter['totalcom'],
		)
		);
		}
	}
	
$tpl->showit();
?>