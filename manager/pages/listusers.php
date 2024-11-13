<?php
define("rashcmsper",'permission');
define("ajax_head",true);
$template = (isset($_POST['permission4rashcms'])) ? 'quickuserper.htm' : 'quickuser.htm';
define('template',$template);
define('mpage',true);
require("ajax_head.php");
$q = $d->query("SELECT * FROM `member` order by `u_id` LIMIT $From,$RPP");
	while ($data = mysql_fetch_array($q)){
    $tpl->block("listtr",array("id"=>$data['u_id'],"text"=>$data['about'],"showname"=>$data['showname'],"tell"=>$data['tell'],"avatar"=>$data['avatar'],"gid"=>$data['gid'],"yid"=>$data['yid'],"ip"=>$data['ip'],"stat"=>$data['stat'],"username"=>$data['user'],"name"=>$data['name'],"users_id"=>$data['u_id'],"email"=>$data['email'],"regdate"=>mytime($config['dtype'],$data['date'],$config['dzone'])));
    }
    $q = $d->getrows("SELECT COUNT(*) as `num` FROM `member`",true);
$page = (isset($_POST['permission4rashcms'])) ? 'permission.php?' : 'member.php?';
rashpage($q,$RPP,5,$CurrentPage,$tpl,'pages',$page);
$tpl->showit();
?>