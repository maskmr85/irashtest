<?php
define('rashcmsper','block');
define("ajax_head",true);
define('template','quickblock.htm');
require("ajax_head.php");
$q = $d->query("SELECT * FROM `block` order by `order`");
$position = array('',$lang['top'],$lang['down'],$lang['right'],$lang['left'],$lang['hide']);
$users = array('',$lang['members'],$lang['public'],$lang['guest']);
	while ($data = mysql_fetch_array($q)){
    $tpl->block("listtr",array("module_name"=>$data['module'],"orderid"=>$data['order'],"text"=>$data['text'],"title"=>$data['name'],"position_id"=>$data['pos'],"users_id"=>$data['users'],"position"=>$position[$data['pos']],"id"=>$data['id'],"users"=>$users[$data['users']]));
    }
$tpl->showit();
?>