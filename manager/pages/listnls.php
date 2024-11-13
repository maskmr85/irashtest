<?php
define("rashcmsper",'link');
define("ajax_head",true);
define('template','quicknl.htm');
require("ajax_head.php");
$q = $d->query("SELECT * FROM `nl`");
	while ($data = mysql_fetch_array($q)){
    $tpl->block("listtr",array("email"=>$data['mail'],"id"=>$data['id']));
    }

    $tpl->showit();
?>