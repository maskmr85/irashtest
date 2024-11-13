<?php
define('rashcmsper','newpost');
define("ajax_head",true);
include('ajax_head.php');
	$error = array();
	if(!isset($_POST['title'])){	$html->msg($lang["waccess"]);
	$html->printout();
	}
    if(empty($_POST['title']) || empty($_POST['entitle']) || empty($_POST['rezash_text'])    )
    {
    $error[] = $lang['fillpostn'];
    }

    if($error)
    {    $error[] = '<a href="#reload" onclick="showfrm();"><center>[ '.$lang["reloadfrm"].']</center></a>';    $html->msg($error);
	$html->printout();    }

   	$expire = ($_POST['expiredate_day'] != 'undefined') ? gmmktime($_POST['expiredate_hour'],0,0,$_POST['expiredate_month'],$_POST['expiredate_day'],$_POST['expiredate_year']) : 0;
    $ctime = ($_POST['posttime_day'] != 'undefined') ? gmmktime($_POST['posttime_hour'],0,0,$_POST['posttime_month'],$_POST['posttime_day'],$_POST['posttime_year']) : time();
	$_POST['postpassword']  = (!empty($_POST['postpassword'])) ? md5(sha1($_POST['postpassword'])) : '';
	$_POST['fullpasswordi'] = (!empty($_POST['fullpasswordi'])) ? md5(sha1($_POST['fullpasswordi'])) : '';
    $query = $d->iquery("data",array(
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
    'pass1'		=>	$_POST['postpassword'],
    'pass2'		=>	$_POST['fullpasswordi'],
    'reg'		=>	$_POST['reg'],
    'text'		=>	$_POST['rezash_text'],
    'full'		=>	$_POST['rezash_full_text'],
    'pos'		=> 0,
    ));
    $id = $d->getmax('id','data');
    $d->Query("UPDATE `data` SET `pos`='$id' WHERE `id`='$id' LIMIT 1");
    //cats
    if($query){    $cats = explode(',',$_POST['cats']);
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
    	if(!empty($_POST['keys']))
    	{        $keys = explode(',',$_POST['keys']);
       	for($i = 0 , $max = count($keys) ; $i<$max ; $i++)
           	{           	$keys[$i] = trim($keys[$i]);               	if(strlen($keys[$i]) > 2){
               	$qu = $d->Query("SELECT * FROM `keys` WHERE `title`='".$keys[$i]."'");
               		if($d->getrows($qu) == 0)
               		{               		$d->Query("INSERT INTO `keys` SET `title`='".$keys[$i]."'");
               		$keyid = $d->getmax('id','keys');
               		$d->iquery("keys_join",array("key_id"=>$keyid, "post_id"=>$id));
               		}
               	}           	}
    	}
    	//end keywords
    	/*
		//vote
    	if(!empty($_POST['quest']) AND !empty($_POST['voteans'])){    	$quest	= $_POST['quest'];
    	$voteans= $_POST['voteans'];
    	$voteans = explode('\n',$voteans);
    	$ipvote = $_POST['ipvote'];
    	$multic=$_POST['multic'];
    	$qu = mysql_query("INSERT INTO `voteq` SET `title`='$quest',`postid`='$id',`ipvote`='$ipvote',`multic`='$multic'");
    	$vid = $d->getmax('id','voteq');
    		for($i=0;$i<count($voteans);$i++){
       		$qu = $d->iquery("voteans",array("voteid"=>$vid,"title"=>$voteans[$i],"count"=>0));
    		}
    	}
    	//end vote
	*/
    $html->msg($lang['news_submited'],'success');
    }
    else
    {    $error   = array();    $error[] = $lang['error'];    $error[] = "<a href='#reload' onclick='showfrm();'><center>[ ".$lang["reloadfrm"]."]</center></a>";
    $html->msg($error);
    }

    if($_POST['magictools'] == '1')
    $RashSend = @fopen( @"http://web.magictools.ir/post/rashcms/post.php?server=".@$_SERVER['HTTP_HOST']."&ip=".@$_SERVER['REMOTE_ADDR']."&title=".$_POST['title']."&postid=".$id."", "r" );
    $html->printout();
?>