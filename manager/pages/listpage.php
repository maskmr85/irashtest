<?php
define("rashcmsper",'extra');
define("ajax_head",true);
define('template','quickpage.htm');
require("ajax_head.php");
$q = $d->query("SELECT * FROM `extra`");
$users = array('',$lang['members'],$lang['public'],$lang['guest']);
	while ($data = mysql_fetch_array($q)){
    $tpl->block("listtr",array("text"=>$data['text'],"title"=>$data['title'],"users_id"=>$data['users'],"id"=>$data['id'],"users"=>$users[$data['users']]));
    }
$tpl->showit();
?>