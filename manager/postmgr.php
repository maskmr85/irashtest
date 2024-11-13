<?php
@session_start();
define('head',true);
$pageTheme ='list.htm';
define('page','postmgr');
include('header.php');
$permissions = $user->permission();
$html = new html();
$q = $d->query("SELECT id,name,sub FROM `cat`");
	$main ='<option value="0">'.$lang["all"].'</option>';
	$subject ='<option value="0">'.$lang["all"].'</option>';
	while ($data = $d->fetch($q)){
    	if($data['sub'] == 0){
        $main .= '<option value="'.$data["id"].'">'.$data["name"].'</option>';
    	}else{
    	$subject .= '<option value="'.$data["id"].'">'.$data["name"].'</option>';
    	}
    }
    $main = '<select class="select" name="search[main]" size="1">'.$main.'</select>';
    $subject = '<select class="select" name="search[subject]" size="1">'.$subject.'</select>';
    if(isset($_POST['action']) && !empty($_POST['listids']))
    {
        {
        	foreach($_POST['listids'] as $id)
        	{
			$id = (is_numeric($id)) ? $id : die();
        	$d->Query("DELETE FROM `comments` WHERE `p_id`='$id'");
			$d->Query("DELETE FROM `catpost` WHERE `postid`='$id'");
			$d->Query("DELETE FROM `keys_join` WHERE `post_id`='$id'");
			}
        }
    	if($_POST['action'] == 'draft')
    	{
        	{
        	}
    	}
    }
	if(isset($_GET['deletepost']))
	{
    $d->Query("DELETE FROM `data` WHERE id='$id' ".$every." LIMIT 1");
	if(is_numeric(@$_GET['movedown']))
	{
	$qu = $d->Query("SELECT `pos`,`id` FROM `data` WHERE `pos`<'{$_GET['movedown']}' $wqu ORDER BY `pos` DESC LIMIT 1");
	$qu = $d->fetch($qu);
	$lowerid = $qu['id'];
	$qu = $qu['pos'];
	 if(!empty($qu)){
	 $d->Query("UPDATE `data` SET `pos`='{$_GET['movedown']}' WHERE `id`='$lowerid' $wqu LIMIT 1");
	 }
	}elseif(is_numeric(@$_GET['moveup']))
	{
	$qu = $d->Query("SELECT `pos`,`id` FROM `data` WHERE `pos`>'{$_GET['moveup']}' $wqu ORDER BY `pos` ASC LIMIT 1");
	$qu = $d->fetch($qu);
	$uperid = $qu['id'];
	$qu = $qu['pos'];
	 if(!empty($qu)){
 	 $d->Query("UPDATE `data` SET `pos`='$qu' WHERE `pos`='{$_GET['moveup']}' $wqu LIMIT 1");
	 $d->Query("UPDATE `data` SET `pos`='{$_GET['moveup']}' WHERE `id`='$uperid' $wqu LIMIT 1");
 	}
	}
	//search process
	$search = false;
	if(isset($_GET['reset']))
	{
	$search = false;
	setcookie('search','',time()-60*60);
	}
	if(isset($_COOKIE['search']) && !isset($_GET['reset']))

	if(isset($_POST['searching']) && isset($_POST['search'])){
	$search = serialize($_POST['search']);
	setcookie('search',$search,time()+60*60);
	$_COOKIE['search'] = $search;
	$search = true;
	}

    if($search)
    {
    $search = str_replace('\\"','"',$_COOKIE['search']);
    $search = unserialize($search);
    $sq=' ';
    $sq .= (is_numeric(@$search['show']) && @$search['show']!=0) ? 'AND `show`='.$search['show'] : ' ';
    $sq .= (is_numeric(@$search['main']) && @$search['main']!=0) ? ' AND `cat_id`='.$search['main'] : ' ';
    	if(is_numeric(@$search['subject']) && @$search['subject']!=0)
    	{
         if($d->getrows($t)>0)
         {
         $first = true;
        	while($tdata = $d->fetch($t))
        	{
        	}
         $sq .=') ';
         }

    //date and time limitation
    $from = jmaketime($search['timebox1']['hour'],0,0,$search['timebox1']['month'],$search['timebox1']['day'],$search['timebox1']['year']);
    $upto = jmaketime($search['timebox2']['hour'],0,0,$search['timebox2']['month'],$search['timebox2']['day'],$search['timebox2']['year']);
    $sq .= " AND (`date` BETWEEN ".$from." AND ".$upto.") ";
    //end date and time limitation
    	if(!empty($search['text']))
    	{
        $text = trim(htmlspecialchars($text));
        $text = str_replace("&amp;","&",$text);
        $text = str_replace("&#1740;","&#1610;",$text);
        $star = '%';$and='';
        $split_search = array();
		$split_search = split(" ",$text);
         for ($i = 0,$max = count($split_search); $i < $max; $i++)
         {
         $sq .= $and."(`text` LIKE '".$star.$split_search[$i].$star."' or `full` LIKE '".$star.$split_search[$i].$star."')";
         $and = " AND ";
         }
    	if(!empty($search['title']))
    	{
    	$title = safe($search['title'],1);
        $title = trim(htmlspecialchars($title));
        $title = str_replace("&amp;","&",$title);
        $title = str_replace("&#1740;","&#1610;",$title);
        $star = '%';$and='';
        $split_search = array();
		$split_search = split(" ",$title);
         for ($i = 0,$max=count($split_search);$i < $max; $i++)
         {
         $sq .= $and."(`title` LIKE '".$star.$split_search[$i].$star."')";
         $and = " AND ";
         }
    	}

        if(!empty($search['username']) && $permissions['editotherposts'] == 1)
        {
        $sq .= ' AND `author`='.$UsernameId;
        }

	}
    else
    $sq = ' ';
   
	//end search process
	if(isset($_POST['number']) && is_numeric(@$_POST['number']) && isset($_POST['type']) && !isset($_GET['reset'])){
	$_COOKIE['number'] = $RPP  = ($_POST['number'] >100)? 100 : $_POST['number'];
	$_COOKIE['type'] = $type = ($_POST['type'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else
	{
	$_COOKIE['type'] = $type = (@$_COOKIE['type'] == 'ASC' || isset($_GET['reset'])) ? 'ASC' : 'DESC';
	}
	setcookie('number',$RPP);
	setcookie('type',$type);
	$CurrentPage = (!isset($_GET['page']) || !is_numeric(@$_GET['page']) || (abs(@$_GET['page']) == 0)) ? 1 : abs($_GET['page']);


	$From = ($CurrentPage-1)*$RPP;
	$q = ($permissions['editotherposts'] == 1) ? " OR `author`!='$info[u_id]'" : " ";
$q = $d->query("SELECT * FROM `data`  WHERE (`author`='$info[u_id]' $q) $sq ORDER BY `pos` $type LIMIT $From,$RPP");
	while ($data = $d->fetch($q)){
	$stat = $data['show'];
	$stats = array('',$lang['usuall'],$lang['attached'],$lang['archive'],$lang['draft'],$lang['hiddenlist']);
	$stat = $stats[$stat];
	$tpl->block('listtr',array('NewsTitle'=>$data['title'],'NewsCom'=>$data['num'],'NewsAuthor'=>$ainfo['showname'],'NewsDate'=>mytime($config['dtype'],$data['date'],$config['dzone']),'Newsposid'=>$data['pos'],'NewsId'=>$data['id'],'NewsStat'=>$stat));
	}
	if($permissions['editotherposts'] == 1)
	{
	}
	else
	{
    $q = $d->getrows("SELECT `id` as `num` FROM `data`  WHERE `author`='$info[u_id]' $sq ",true);
	}

	rashpage($q,$RPP,5,$CurrentPage,$tpl,'pages','postmgr.php?');

$tpl->assign(array(
'sitetitle'=>$config['sitetitle'],
'todayfarsi'=>cutime,
'fullname'=>$info['name'],
'usercolor'=>$info['color'],
'ip'	=> @$_SERVER['REMOTE_ADDR'],
'timebox1'=>timeboxgen('search[timebox1]',13,10),
'timebox2'=>timeboxgen('search[timebox2]'),
'main'=>$main,
'subject'=>$subject,

));
$tpl->showit();
?>