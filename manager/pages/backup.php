<?php
define('rashcmsper','backup');
define("ajax_head",true);
require("ajax_head.php");
$lang = $lang['backup'];
function printpm($msg = 'waccess',$type = 'error'){
$html = new html();
global $lang;
$html->msg($lang[$msg],$type);
$html->printout(true);
}

$task = (!isset($_POST['task'])) ? printpm() : $_POST['task'];
if($permissions['backup'] != '1'){
ptintpm();
}
function Rashbackup($dbname){
$Rashb = '';
$tbllist = mysql_list_tables($dbname);
while($R_t = mysql_fetch_row($tbllist)){
$Create_tbl = mysql_query("SHOW CREATE TABLE `$R_t[0]`");
while($R_c_t = mysql_fetch_array($Create_tbl)){
$Rashb .= "
mysql_query(\"".$R_c_t['Create Table']."\")";
}
$Rashb .= "; ";
$Q_t = mysql_query("SELECT * FROM `$R_t[0]`");
while($R_c_f = mysql_fetch_row($Q_t)){
$Rashb .= "
mysql_query(\""."INSERT INTO `$R_t[0]` VALUES('$R_c_f[0]' ";
for($i=1;$i<sizeof($R_c_f);$i++){
$rcu = str_replace("'","\'",$R_c_f[$i]);
$rcu = str_replace('"','\"',$R_c_f[$i]);
$Rashb .= ", '$rcu' ";
}
$Rashb .= ");\"); ";
}
$Rashb .= " ";
}
$ctime = time();

$bfile = fopen("../backup/RashCMSBackup_".$ctime.".php","w");
$Rashresult = fwrite($bfile,"
<?php
/***************************************************************************
 *                                  Rash CMS
 *                          -------------------
 *   copyright            : (C) 2009 The RashCMS  \$Team = \"www.rashcms.com\";
 *   copyright            : (C) 2009 The RashCMS  \$Team = \"www.mihanphp.com\";
 *   copyright            : (C) 2009 The RashCMS  \$Team = \"www.mihanphp.ir\";
 *   email                : info@rashcms.com
 *   email                : rashcms@gmail.com
 *   programmer           : Reza Shahrokhian
 *   File Name            : RashCMSBackup_".$ctime."
 ***************************************************************************/
//         Security
if ( !defined('news_security'))
{
die(\"You are not allowed to access this page directly\");
}
".$Rashb."
?>");
if($Rashresult){
return true;
}else{
return false;
}
}
function Rashdobackup($dbname,$id){
$Rashb = '';
$tbllist = mysql_list_tables($dbname);
while($R_t = mysql_fetch_row($tbllist)){
mysql_query("DROP TABLE `$R_t[0]`");
}
$d_id = str_replace('/','',safe($id,1));
$d_id = str_replace('\\','',$d_id);
$d_id = str_replace('..','',$d_id);
if(($d_id == 'index.php')or($d_id == 'index.html')or($d_id == '.htaccess'))
{
printpm();
die();
}
include('../backup/'.$id);
return true;
}

switch ($task){
	case "new":
	$Rashresult = Rashbackup($dbconfig['database']);
    if($Rashresult){    printpm('bccreated','success');
    }else{    printpm('bcnotcreated');    }
    break;
    default:
    printpm();
    break;
    case 'doback':
    if(!isset($_POST['id'])){printpm();}else{
    $d_id = str_replace('/','',safe($_POST['id'],1));
    $d_id = str_replace('\\','',$d_id);
    $d_id = str_replace('..','',$d_id);
    if(($d_id == 'index.php')or($d_id == 'index.html') or($d_id == '.htaccess'))
    {
    printpm();
    }
    $Rashresult = Rashdobackup($dbconfig['database'],$d_id);
    if($Rashresult){    printpm('bcbacked','success');
    }else{    printpm('bcnotbacked');
    }
    }
	break;
	case 'del':
    if(!isset($_POST['id'])){printpm();}
    else{
    $d_id = str_replace('/','',safe($_POST['id'],1));
    $d_id = str_replace('\\','',$d_id);
    $d_id = str_replace('..','',$d_id);
    if(($d_id == 'index.php')or($d_id == 'index.html')or($d_id == '.htaccess'))
    {
    printpm();
    }
    $Rashresult = @unlink ( "../backup/".$d_id );
    if($Rashresult){    printpm('bcld','success');
    }else{    printpm('bcnotld');
    }
    }
    break;
default:
printpm();
}
?>