<?php
define('rashcmsper','postmgr');
define('ajax_head',true);
include('ajax_head.php');
$info = $user->info;
	$error = array();
	if(isset($_POST['title'])){
 		if(!is_numeric(@$_POST['postid']))
 		{
 		$html->msg($lang['waccess']);
		$html->printout(true);
		}
		$id = $_POST['postid'];
		if($permissions['editotherposts'] == 0)
		{
		$q = $d->Query("SELECT `author` FROM `data` WHERE `id`='$id' LIMIT 1");
		$q = $d->fetch($q);
		if($q['author'] != $info['u_id'])
		$html->msg($lang['waccess']);
		$html->printout(true);
		}
    	if(empty($_POST['title']) || empty($_POST['entitle']) || empty($_POST['rezash_text'])    )
    	{
        $error[] = $lang['fillpostn'];
    	}

    	if($error)
    	{    	$error[] = '<a href="#reload" onclick="showfrm();"><center>[ '.$lang["reloadfrm"].']</center></a>';    	$html->msg($error);
		$html->printout();    	}



   		$expire = ($_POST['expiredate_day'] != 'undefined') ? gmmktime($_POST['expiredate_hour'],0,0,$_POST['expiredate_month'],$_POST['expiredate_day'],$_POST['expiredate_year']) : 0;
    	$ctime = ($_POST['posttime_day'] != 'undefined') ? gmmktime($_POST['posttime_hour'],0,0,$_POST['posttime_month'],$_POST['posttime_day'],$_POST['posttime_year']) : time();
		$arr = array(
    	'title'		=>	$_POST['title'],
    	'entitle'	=>	engconv($_POST['entitle']),
    	'timage'	=>	$_POST['timage'],
    	'cat_id'	=>	intval($_POST['main']),
    	'author'	=>	$info['u_id'],
    	'context'	=>	$_POST['context'],
    	'hits'		=>	intval($_POST['hits']),
    	'show'		=>	$_POST['show'],
    	'scomments'	=>	$_POST['scomments'],
    	'star'		=>	$_POST['star'],
    	'expire'	=>	$expire,
    	'date'		=>	$ctime,
    	'reg'		=>	$_POST['reg'],
    	'text'		=>	$_POST['rezash_text'],
    	'full'		=>	$_POST['rezash_full_text'],
    	'pos'		=> 0,
    	);
		if(!empty($_POST['postpassword']))
		{
		if(@$_POST['postpassword'] != '**hidden**')
				$arr['pass1'] = md5(sha1($_POST['postpassword']));
		}
		else
		$arr['pass1'] = '';
		if(!empty($_POST['fullpasswordi']))
		{
		if(@$_POST['fullpasswordi'] != '**hidden**')
				$arr['pass2'] = md5(sha1($_POST['fullpasswordi']));
		}
		else
		$arr['pass2'] = '';
		$query = $d->uquery("data",$arr,"id= '".$id."' ");
        //cats
    	if($query){      	$cats = explode(',',$_POST['cats']);
      	$d->Query("DELETE FROM `catpost` WHERE `postid`='$id'");
	   		for($i=0 , $max = count($cats); $i<$max; $i++){
    			$enname = $cats[$i];
    			if(!empty($enname)){
    			$qu = $d->Query("SELECT `id` FROM `cat` WHERE `enname`='$enname'");
    			$qu = $d->fetch($qu);
        		$qu = $qu['id'];
        		$d->Query("INSERT INTO `catpost` SET `catid`='$qu',`postid`='$id'");
    			}
    		}
    	//end cats
    		//keywords
    		$d->Query("DELETE FROM `keys_join` WHERE `post_id`='$id'");
    		if(!empty($_POST['keys']))
    		{            $keys = explode(',',$_POST['keys']);
            	for($i = 0 , $max = count($keys) ; $i<$max ; $i++)
            	{            	$keys[$i] = trim($keys[$i]);                	if(strlen($keys[$i]) > 2){
                	$qu = $d->Query("SELECT * FROM `keys` WHERE `title`='".$keys[$i]."'");
                		if($d->getrows($qu) == 0)
                		{                 		$d->Query("INSERT INTO `keys` SET `title`='".$keys[$i]."'");
                 		$keyid = $d->getmax('id','keys');
                 		$d->iquery("keys_join",array("key_id"=>$keyid, "post_id"=>$id));
                		}
                	}            	}
    		}
    		//end keywords
    	$html->msg($lang['news_edited'],'success');
    	}
    	else
    	{    	$error   = array();    	$error[] = $lang['error'];    	$error[] = "<a href='#reload' onclick='showfrm();'><center>[ ".$lang["reloadfrm"]."]</center></a>";
    	$html->msg($error);
    	}
    	$html->printout();
    }
?>