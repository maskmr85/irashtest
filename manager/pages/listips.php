<?php
define('rashcmsper','banned');
define("ajax_head",true);
define('template','quickip.htm');
require("ajax_head.php");
$q = $d->query("SELECT * FROM `bann`");
	while ($data = mysql_fetch_array($q)){
    $tpl->block("listtr",array("ip"=>$data['ip'],"mess"=>$data['mess'],"id"=>$data['id']));
    }
$tpl->showit();
?>