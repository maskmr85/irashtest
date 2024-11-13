<?php
define('rashcmsper','poll');
define('template','quickpolla.htm');
define("ajax_head",true);
require("ajax_head.php");
$id =  (!is_numeric(@$_POST['id'])) ? die($lang['waccess']) : $_POST['id'];
$tpl = new Rashcms();
$tpl-> load($Themedir.$pageTheme);
$lang = $lang['poll'];
$title = $d->query("SELECT `title` FROM `voteq` WHERE `id`='$id'");
$title = $d->fetch($title);
$title = $title['title'];
$rashcms = $d->query("SELECT SUM(count) as sum FROM `voteans` WHERE `voteid`='$id'");
$rashcms = $d->fetch($rashcms);
$rashcms = $rashcms['sum'];
$rashcms = (empty($rashcms) || $rashcms == 0) ? 1 : $rashcms;
$q = $d->query("SELECT * FROM `voteans` WHERE `voteid`='$id' ORDER by `id` DESC");
	while ($data = $d->fetch($q)){	$percent = round(($data['count']/$rashcms)*100,2);    $tpl->block("listtr",array("vote_title"=>$data['title'],"count"=>$data['count'],"rashcms"=>$percent,"cid"=>$data['id']));

    }
$tpl->assign(array("title"=>$title,"id"=>$id));
$tpl->showit();
?>