<?php
define('head',true);
$pageTheme ='edit.htm';
define('page','postmgr');
include('header.php');
function check(){
$html->printout(true);
}
$postid = (!isset($_GET['id']) || !is_numeric(@$_GET['id'])) ? check() : $_GET['id'];

    $qu = $d->Query("SELECT * FROM `data` WHERE `id`='$postid'");
	$data = $d->fetch($qu);
	$qu = $d->Query("SELECT `catid` FROM `catpost` WHERE `postid`='$postid'");
	while($scdata = $d->fetch($qu)){
    $subcats[$scdata['catid']] = 'cat';
	}
$q = $d->query("SELECT * FROM `cat` WHERE `sub`='0'");
	$main ='';
	$mains ='';
	$mains_ajax = '';
	while ($cdata = $d->fetch($q)){
    $mains.='<optgroup label="&nbsp;'.$cdata['name'].'&nbsp;">';
    $id = $cdata['id'];
    $main.='<b>'.$cdata['name'].'</b><br>';
    $qu = $d->query("SELECT * FROM `cat` WHERE `sub`='$id'");
    while ($datau = mysql_fetch_array($qu)){
    $one = ($datau['id'] == $data['cat_id']) ? " selected ": ' ';
    $tow = (@$subcats[$datau['id']] == 'cat') ?  " checked " : ' ';
    $mains.='<option value="'.$datau["id"].'"'.$one.'>&nbsp;&nbsp;'.$datau["name"].'&nbsp;&nbsp;</option>';
    $main.='<input  type="checkbox" name="'.$datau["enname"].'"'.$tow.' id="'.$datau["enname"].'" value="'.$datau["id"].'" ><label for="'.$datau["enname"].'" class="hand">'.$datau["name"].'</label> <br>' ;
	$mains_ajax .="'".$datau["enname"]."',";
    $last = $datau["enname"];
	}
    $mains.='</optgroup>';
    }
    $mains_ajax = str_replace($last."',",$last."'",$mains_ajax);
    $main .= '';
    $maine  = '<select name="main" id="main" class="inp">'.$mains;
    $rmain = ''.$main;
    $expiredate = timeboxgen('expiredate');
    $posttime   = timeboxgen('posttime');
    $author = new user();
    $author = $author->info(false,$data['author']);
    if(!empty($data['full'])){
    $tpl->block("hasfull",array());
    }else{
    }
    if(!empty($data['pass1'])){
	$data['pass1'] = '**hidden**';
    $tpl->assign("postpassword","");
    $tpl->block("hasfull",array());
    }else{
    $tpl->assign("postpwch","");
    $tpl->assign("postpassword","none");
    }
    if(!empty($data['pass2'])){
	$data['pass2'] = '';
    $tpl->assign("fpostpwch","checked");
    $tpl->assign("postfullpassword","");
    $tpl->block("hasfull",array());
    }else{
    $tpl->assign("fpostpwch","");
    $tpl->assign("postfullpassword","none");
    }
	/*
    $qu = $d->Query("SELECT * FROM `voteq` WHERE `postid`='$postid'");
    $qu = $d->fetch($qu);
    if(is_numeric($qu['id'])){
    $tmp = ($qu['ipvote'] == 1) ? $tpl->assign("ipvote","checked"): '';
    $tmp = ($qu['multic'] == 1) ? $tpl->assign("multic","checked"): '';
    $tmp = $qu['id'];
    $qu = $d->Query("SELECT * FROM `voteans` WHERE `voteid`='$tmp'");
    	$ans = '';
    	while($tmp = $d->fetch($qu)){
    	}
    $tpl->assign("voteans",trim($ans));

    }else{
    }
	*/
    for($i=1;$i<5;$i++)
    {
    	}else{
    	}
    }
    $keys = '';$def='';
    $tmp = ($qu['star'] == 1) ? $tpl->assign("star","checked"): '';
$qu = $d->Query("SELECT `key_id` FROM `keys_join` WHERE `post_id`='$postid'");
   	while($tmp = $d->fetch($qu)){
    	$qus = $d->Query("SELECT `title` FROM `keys` WHERE `id`='".$tmp['key_id']."' LIMIT 1");
    	$tmps = $d->fetch($qus);
    	$keys .= $def.$tmps['title'];
   		$def = ', ';
    	}
   	}
$def = empty($def) ? $tpl->assign("keys","") : $tpl->assign("keys",$keys);


    for($i=1;$i<4;$i++)
    {
    	if($data['scomments'] == $i){
    	$tpl->assign("scomments".$i,"selected");
    	}else{
    	$tpl->assign("scomments".$i,"");
    	}
    }
    if($data['reg'] == 1){
    $tpl->assign("reg1","selected");
    $tpl->assign("reg2","");
    }else{
    $tpl->assign("reg1","");
    $tpl->assign("reg2","selected");
    }


    $tpl->assign(array(
    'main'=>$maine,
    'subject'=>$rmain,
    'expiredate'=>$expiredate,
    'posttime'=>$posttime,
    'cats_id'	=> $mains_ajax,
    'title'		=>	$data['title'],
    'entitle'	=>	engconv($data['entitle']),
    'timage'	=>	$data['timage'],
    'author'	=>	$author['name'],
    'context'	=>	$data['context'],
    'hits'		=>	intval($data['hits']),
    'show'		=>	$data['show'],
    'scomments'	=>	$data['scomments'],
    'star'		=>	$data['star'],
    'pass1'		=>	$data['pass1'],
    'pass2'		=>	$data['pass2'],
    'reg'		=>	$data['reg'],
    'text'		=>	$data['text'],
    'fulltext'	=>	$data['full'],
    'pos'		=> 0,
    'postid'	=> $postid,
    ));
$tpl->showit();
?>