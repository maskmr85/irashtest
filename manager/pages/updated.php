<?php
define('rashcmsper','update');
define("ajax_head",true);
require("ajax_head.php");
define('crrentver','3.0.0.0');
@$file = file_get_contents("http://sv.rashcms.ir/latest.php?current=".crrentver);
if(!$file)
{
$html->printout();
}
echo $file;

?>