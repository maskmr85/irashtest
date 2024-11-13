<?php
define('head',true);
define('page','newsletter');
$pageTheme ='nl.htm';
include('header.php');
$q = $d->getrows("SELECT `stat` FROM `module` WHERE `name`='newsletter' LIMIT 1",true);
if($q <= 0)
{
HEADER("LOCATION: index.php");
die();
}
$html = new html();
$mail = $d->Query("SELECT * FROM `nls`");
$mail = $d->fetch($mail);
$stat = (empty($mail['SmtpHost']) && empty($mail['SmtpUser']) && empty($mail['SmtpPassword'])) ? false : true;
$html->cbox('SmtpChk',$stat);
if($stat){$tpl->block('smptjs',array());
}else{$mail['SmtpHost'] = '';$mail['SmtpUser']='';$mail['SmtpPassword']='';
}
$stat = (empty($mail['msperpack']) && empty($mail['mailperpack'])) ? false : true;

$html->cbox('PackUse',$stat);
if($stat){
$tpl->block('Packjs',array());
}else{
$mail['msperpack'] = '';$mail['mailperpack']='';
}

$tpl->assign(array(
'SmtpHost'		=>$mail['SmtpHost'],
'SmtpUser'		=>$mail['SmtpUser'],
'SmtpPassword'	=>$mail['SmtpPassword'],
'mailperpack'	=>$mail['mailperpack'],
'msperpack'		=>$mail['msperpack'],
));


$page = (is_numeric(@$_GET['page'])) ? $_GET['page'] : '0';$tpl->assign('page',$page);
$page = ($page != '0') ? $tpl->block('page',array()) : '';
$tpl->showit();
?>