<?php
$show_posts = true;
$pageTheme ='main.htm';
$Admin_Paras = array();
define('crrentver','3.0.0.0');
define("head",true);
define('page','index');
$script = '';
$single_post = false;
include('header.php');
if($show_posts)
{
@$type = ($type !='DESC' && $type != 'ASC') ? 'ASC' : $type;
@$From = (!is_numeric($From)) ? 1 : abs($From);
@$RPP = (!is_numeric($RPP)) ? 10 : abs($RPP);
@$CurrentPage = (!is_numeric($CurrentPage)) ? 1 : abs($CurrentPage);
$tpl->assign('Page',1);
$ctimestamp = time();
	if(!defined('customized_post_query'))
	{
	$post_q = $d->Query("select * FROM `data` WHERE `date` <= '$ctimestamp' AND (`expire`='0' OR `expire`='' OR `expire`>'$ctimestamp') AND (`show`!='4' || `show`='2')  order by `id` desc LIMIT $From,$RPP");
	$t_pr = $d->getrows("SELECT `id` FROM `data` WHERE `date` <= '$ctimestamp' AND (`expire`='0' OR `expire`='' OR `expire`>'$ctimestamp') AND (`show`!='4' || `show`='2')  order by `id` desc",true);
	}
	elseif(customized_post_query_value == '')
	die("RashCMS :: Wrong Query...!");
	else
	{
	$post_q = $d->Query(customized_post_query_value);
	$t_pr = customized_post_query_value_t;
	}
	if($d->getrows($post_q) > 0)
	{
	$tpl->assign('RashCMS',1);
	while($post_data = $d->fetch($post_q))
	{
	if(($post_data['scomments'] != '2' && $config['comment']!='4') OR $config['comment']=='2' OR $config['comment']!='3')
		$tpl->assign('Comment',1);
	$cat		= isset($cats[$post_data['cat_id']]) ? $cats[$post_data['cat_id']] : '';
	$link		= ($config['seo'] == '1') ?	'post-'.$post_data['id'].'.html' : 'index.php?module=cat&postid='.$post_data['id'];
	$sub_link	= ($config['seo'] == '1') ?	'cat-'.$post_data['id'].'.html' : 'index.php?module=cat&catid='.$post_data['cat_id'];
	if(isset($authors[$post_data['author']]))
	$name = $authors[$post_data['author']];
	else
	{
	$iq = $d->Query("SELECT `name`,`showname` FROM `member` WHERE  `u_id` = '$post_data[author]' LIMIT 1");
	$iiq = $d->fetch($iq);
	$name = (empty($iiq['showname'])) ? $iiq['name'] : $iiq['showname'];
	$authors[$post_data['author']] = $name;
	}
	if(!empty($post_data['pass1']))
		{
		$p = $post_data['text'];
			if(isset($_POST['post_password']))
			{
			if(md5(sha1($_POST['post_password'])) != $post_data['pass1'])
			$p = $lang['wpass'].str_replace('%postid%',$post_data['id'],$lang['protected']);
			else
				{
					$_SESSION['post_sess_us_'] = $post_data['id'];
					$p = $post_data['text'];
				}
			}
			elseif(@$_SESSION['post_sess_us_'] != $post_data['id'])
			$p = str_replace('%postid%',$post_data['id'],$lang['protected']);
		$post_data['text'] = $p;
		}
		$context = '';
		if(!empty($post_data['pass2']) && ($single_post))
			{
			$p = $post_data['full'];

				if(isset($_POST['fpost_password']))
				{
				if(md5(sha1($_POST['fpost_password'])) != $post_data['pass2'])
				$p = $lang['wpass'].str_replace('%postid%',$post_data['id'],$lang['fprotected']);
				else
					{
						$_SESSION['post_sess_us_f'] = $post_data['id'];
						$p = $post_data['full'];
					}
				}
				elseif(@$_SESSION['post_sess_us_f'] != $post_data['id'])
				$p = str_replace('%postid%',$post_data['id'],$lang['fprotected']);
			$post_data['full'] = $p;
			}

		if($single_post && !empty($post_data['full']))
		$text = $post_data['text'].'<br>'.$post_data['full'];
		else
		$text = $post_data['text'];
	//star rating
	$star = '';$id = $post_data['id'];
	if($post_data['star'] == '1')
    $star = '<span id="rate_'.$id.'" dir="rtl"><a href="javascript:rate_send(\''.$id.'\',\'1\')"><img src="'.$Themedir.'img/rate_off.gif" id="my_rate_'.$id.'_1" onmouseover="show_rate_on( \''.$id.'\',\'1\')" onmouseout="show_rate_off( \''.$id.'\',\'1\' )" alt="one" border="0"></a><a href="javascript:rate_send(\''.$id.'\',\'2\')"><img src="'.$Themedir.'img/rate_off.gif" id="my_rate_'.$id.'_2" onmouseover="show_rate_on( \''.$id.'\',\'2\')" onmouseout="show_rate_off( \''.$id.'\',\'2\' )" alt="two" border="0"></a><a href="javascript:rate_send(\''.$id.'\',\'3\')"><img src="'.$Themedir.'img/rate_off.gif" id="my_rate_'.$id.'_3" onmouseover="show_rate_on( \''.$id.'\',\'3\')" onmouseout="show_rate_off( \''.$id.'\',\'3\' )" alt="three" border="0"></a><a href="javascript:rate_send(\''.$id.'\',\'4\')"><img src="'.$Themedir.'img/rate_off.gif" id="my_rate_'.$id.'_4" onmouseover="show_rate_on( \''.$id.'\',\'4\')" onmouseout="show_rate_off( \''.$id.'\',\'4\' )" alt="four" border="0"></a><a href="javascript:rate_send(\''.$id.'\',\'5\')"><img src="'.$Themedir.'img/rate_off.gif" id="my_rate_'.$id.'_5" onmouseover="show_rate_on( \''.$id.'\',\'5\')" onmouseout="show_rate_off( \''.$id.'\',\'5\' )" alt="five" border="0"></a></span>';
	$post_data['context'] = empty($post_data['context']) ? $lang['context'] : $post_data['context'];
	if($post_data['reg'] == '2' && !$login)
	$text = reglink($text);
	$arr = array(
	'title'		=>	$post_data['title'],
	'subject'	=>	$cat,
	'id'		=>	$post_data['id'],
	'link'		=>	$link,
	'sub_link'	=>	$sub_link,
	'sub_id'    =>	$post_data['cat_id'],
	'num'		=>	$post_data['num'],
	'body'		=>	smile($text),
	'date'		=>	mytime($config['dtype'],time(),$config['dzone']),
	'author'	=>	$name,
	'entitle'	=>	$post_data['entitle'],
	'image'		=>	$post_data['timage'],
	'numhits'	=>	$post_data['hits'],
	'starrating'=>	$star);
	if(!empty($post_data['full']))
	{
	if($single_post)
	$d->Query("UPDATE `data` SET `hits`=`hits`+1 WHERE `id`='$post_data[id]' LIMIT 1");
	$arr['Hits'] = 1;
	}
	if(!empty($post_data['full']) && !($single_post))
	{
	$arr['Fulltpl']=1;$arr['context']=$post_data['context'];
	}
	$tpl-> block('Rsh',$arr);
	}
	}
	else
	$tpl -> block('Rsh',  array(
			'subject'	=> $config['sitetitle'],
			'sub_id'	=> 1,
			'sub_link'	=> 'index.php',
			'link'  	=> 'index.php?module=member',
			'title' 	=> $config['sitetitle'],
			'body'  	=> '<div class=error>'.$lang['404s'].'<div>',
			)
			);
if(defined('custom_p_url'))
$pages_url = (isset($pages_url)) ? $pages_url :  'index.php?';
else
$pages_url = 'index.php?';
$seo = ($config['seo'] == '1') ? true : false;
rashpage($t_pr,$RPP,5,$CurrentPage,$tpl,'pages',$pages_url,$seo);
}
if(count($Admin_Paras) > 0)
	{
		$t='';
		foreach($Admin_Paras as $value)
			$t .= $value;
	$tpl->assign('Admin_Paras',$t);
	}
	else
	$tpl->assign('Admin_Paras','');
	$tpl->assign('scripts',$script);
$tpl->showit();
?>