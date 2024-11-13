<?php
$pageTheme ='comment.htm';
define("head",true);
define('page','comment');
define('noblock',true);
include('header.php');
$sq = '';
 If (!isset($_GET['id']) or (!is_numeric(@$_GET['id']))){header('location: index.php');die();}
$id = $_GET['id'];
$tpl ->assign('poid',$id);
 $error = '';
 $inf = $d->Query("SELECT `scomments`,`title`,`show` FROM `data` WHERE `id`='$id' LIMIT 1",true);
 $inf = $d->fetch($inf);
 $tpl->assign('title',$inf['title']);
 if(isset($permissions['comment']))
	if($permissions['comment'] != '1')
		$error = $lang['limited_area'];
 if($config['comment'] == '4')
 $error = $lang['disabled'];
 elseif(empty($error))
 {
 	
	if ($inf['scomments'] == '2' && $config['comment'] != '2' && $config['comment'] != '3')
	$error = $lang['disabled'];
	
	if(($inf['scomments'] == '3' && $config['comment'] != '2') OR $config['comment'] == '3')
	{
	$sq = " AND `active`!='0' ";
	$tpl->assign('activation',1);
	}
 if(isset($_GET['login']) && isset($_POST['username']) && isset($_POST['password']) && empty($error))
 {
	if(!$user->checkimg('',$config['tries']))
	$error = $lang['lots_tries'];
	elseif($user->login($_POST['username'],$_POST['password'])){
	HEADER("LOCATION: comment.php?id=".$_GET['id']);die();
	}
	else
	{
	$_SESSION['tries'] = intval(@$_SESSION['tries'])+1;
	$error = $lang['wup'];
	}
 }
 if(isset($_GET['logout']) && empty($error))
 {
 $user->logout();
 HEADER("LOCATION: comment.php?id=".$_GET['id']);die();
 }
$login = isset($login) ? $login : false;
if($login)
	{
	$name = (empty($user->info['showname'])) ? $user->info['name'] : $user->info['showname'];
	$tpl->assign(array(
	'Member'	=>	1,
	'user'		=>	$user->info['user'],
	'fullname'	=>	$name,
	'disable'	=>	'disabled',
	'email'		=>	$user->info['email'],
	));
	}
	else
	{
	$email	=	isset($_POST['email']) ? $_POST['email'] : '';
	$name	=	isset($_POST['name'])  ? $_POST['name'] : '';
	$tpl->assign(array(
	'Guest'		=>	1,
	'fullname'	=>	$name,
	'email'		=>	$email,
	));	
	}
        if(empty($error)){
		if(!isset($_GET['task'])){
        $tpl ->assign('Form',1);
        $tpl ->assign('List',1);
		@$type = ($type !='DESC' && $type != 'ASC') ? 'ASC' : $type;
		@$From = (!is_numeric($From)) ? 1 : abs($From);
		@$RPP = (!is_numeric($RPP)) ? 10 : abs($RPP);
		@$CurrentPage = (!is_numeric($RPP)) ? 1 : abs($CurrentPage);
        $comm = $d->Query("SELECT * FROM `comments` WHERE `p_id`='$id' AND `active`!='2' $sq  ORDER BY `c_id` $type LIMIT $From ,$RPP");
        while ($cs = $d->fetch($comm)){
		if($cs['memberid'] != '-1'){
		$sender_info = $user->info(false,$cs['memberid']);
		$sender_user = $sender_info['user'];
		$sender_level = $lang['users']['member'];
		$sender_name = (empty($sender_info['showname'])) ? $sender_info['name'] : $sender_info['showname'];
		}else{
		$sender_user = 'guest';
		$sender_level = $lang['users']['guest'];
		$sender_name = $cs['c_author'];
		}
		$re = $reu = $ret = $reta = 'a';
		$replier_info['user'] = $replier_name = '';
		if(!empty($cs['ans'])){
		$replier_info = $user->info(false,$cs['ansid']);
		$replier_name = $replier_info['name'];
		$re = 'reply_name';$reu = 'reply_user';$ret = 'answer';$reta = 'Ans';
		}
        $tpl -> block('comments',  array(
        'level'		=>	$sender_level,
		'name'		=>	$sender_name,
		'user'		=>	$sender_user,
        'text'		=>	nl2br(smile($cs['text'])),
        'date'		=>	mytime($config['dtype'],$cs['date'],$config['dzone']),
        'url'		=>	$cs['url'],
		'body'		=>	smile(nl2br($cs['text'])),
		$re			=>	$replier_name,
		$reu		=>	$replier_info['user'],
		$ret		=>	$cs['ans'],
		$reta		=>	1,
        )
        );
        }
		$t_com = $d->getrows("SELECT `c_id` FROM `comments` WHERE `p_id`='$id'",true);
		rashpage($t_com,$RPP,5,$CurrentPage,$tpl,'pages','index.php?module=member&action=list&');
        }
        elseif($_GET['task']== 'new'){
		$required = array('comment','RashCMS');
		if(!$login)
			{
			$required[] = 'name';$required[] = 'email';
			}
			
		for($i=0,$t=count($required),$c = true;$i< $t && $c;$i++)
			if(empty($_POST[$required[$i]]))
				{
				$c = false;
				$error = $lang['allneed'];
				}
		
		if($c)
			{
			if($login)
			{
			$author 	=	(empty($user->info['showname'])) ? $user->info['name'] : $user->info['showname'];
			$email		=	$user->info['email'];
			$memberid	=	$user->info['u_id'];
			}
			else
			{
			$author 	=	$_POST['name'];
			$email		=	$_POST['email'];
			$memberid	=	'-1';
			}
			 if( $_SESSION['rash_secimg'] !== $_POST['RashCMS'])
				{
				$c = false;
				$error = $lang['wrongseccode'];
				}
				elseif(!email($email))
				{
				$c = false;
				$error = $lang['wmail'];
				}
			}
		if($c) 
			{
			$randcode =rand(1000,100000);
			$_SESSION['rash_secimg'] = $randcode;
			$_POST['url'] = empty($_POST['url']) ? '' : $_POST['url'];
			$_POST['url'] = str_replace(array('http://','www','https://'),'',$_POST['url']);
			$_POST['url'] = 'http://'.$_POST['url'];
			$d->iquery("comments",array(
			"p_id"		=>	$id,
			"c_author"	=>	$author,
			"text"		=>	$_POST['comment'],
			"date"		=>	time(),
			"ip"		=>	getRealIpAddr(),
			"url"		=>	$_POST['url'],
			"email"		=>	$email,
			"ans"		=>	'',
			"memberid"	=>	$memberid,
			"active"	=>	0,
			"ansid"		=>	0,
			));	
			$d->Query("UPDATE `data` SET `num`=`num`+1 WHERE `id`='$id' LIMIT 1");
			$tpl->assign(array('Success'=>1,'msg'=>$lang['comsent']));
			}
     
        }
        }
        }
        
		if(!empty($error))
		$tpl->assign(array('Error'=>1,'msg'=>$error.'<br><a href="javascript:history.go(-1);">'.$lang['back'].'</a>'));
        $tpl ->showit();
?>