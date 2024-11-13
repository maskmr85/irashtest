<?php
/***************************************************************************
 *                                  Rash CMS
 *                          -------------------
 *   copyright            : (C) 2009 The RashCMS  $Team = "www.rashcms.com";
 *   copyright            : (C) 2009 The RashCMS  $Team = "www.mihanphp.com";
 *   copyright            : (C) 2009 The RashCMS  $Team = "www.mihanphp.ir";
 *   email                : info@rashcms.com
 *   email                : rashcms@gmail.com
 *   programmer           : Reza Shahrokhian
 *   File Name            : RashCMSBackup_1284480823
 ***************************************************************************/
//         Security
if ( !defined('news_security'))
{
die("You are not allowed to access this page directly");
}
$r = @file_get_contents('rashcms.lock');
if($r == '1')
die('Install is disabled !!');
require('../includes/config.php');
require('../includes/db.php');
$d = new dbclass();
$d->mysql($_SESSION['host'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['db']);
$d->query("SET CHARACTER SET utf8;");
$d->query("SET SESSION collation_connection = 'utf8_general_ci'");
@session_start();
if(@$_SESSION['step'] != 'admindbc')
die('WWW.RASHCMS.COM -- Wrong Access !!!');
$d->Query("ALTER TABLE `member` ADD `prv` VARCHAR( 255 ) NULL ,
ADD `yid` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
ADD `gid` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
ADD `avatar` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
ADD `about` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
ADD `showname` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
ADD `tell` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
ADD `color` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '000000',
ADD `stat` INT( 1 ) NULL DEFAULT '1'");
$d->Query("DROP TABLE IF  EXISTS `permissions`");
$d->Query("CREATE TABLE `permissions` (
  `u_id` int(11) NOT NULL,
  `newpost` int(1) NOT NULL DEFAULT '0',
  `editotherposts` int(1) NOT NULL DEFAULT '0',
  `backup` int(1) NOT NULL,
  `access_admin_area` int(1) NOT NULL DEFAULT '0',
  `ads` int(11) NOT NULL DEFAULT '0',
  `postmgr` int(1) NOT NULL DEFAULT '0',
  `comment` int(1) NOT NULL DEFAULT '0',
  `cat` int(1) NOT NULL DEFAULT '0',
  `simplelink` int(1) NOT NULL DEFAULT '0',
  `block` int(1) NOT NULL DEFAULT '0',
  `extra` int(1) NOT NULL DEFAULT '0',
  `member` int(1) NOT NULL DEFAULT '0',
  `inbox` int(1) NOT NULL DEFAULT '0',
  `uc` int(1) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `newsletter` int(1) NOT NULL DEFAULT '0',
  `poll` int(1) NOT NULL DEFAULT '0',
  `template` int(1) NOT NULL DEFAULT '0',
  `setting` int(1) NOT NULL DEFAULT '0',
  `permission` int(1) NOT NULL,
  `module` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8"); 
$q = $d->Query("SELECT * FROM `admin`");  
while($data = $d->fetch($q))
{
if(!isset($data['email']))
$data['email'] = 'rashcms@gmail.com';
$d->iquery("member",array(
	'prv'		=>	'',
	'name'		=>	$data['name'],
	'user'		=>	$data['username'],
	'pass'		=>	$data['password'],
	'date'		=>	time(),
	'ip'		=>	@$_SERVER['REMOTE_ADDR'],
	'email'		=>	$data['email'],
	'yid'		=>	'',
	'gid'		=>	'',
	'tell'		=>	'',
	'about'		=>	'',
	'showname'	=>	'',
	'color'		=>	'#000000',
	'stat'		=>	'1',
	'avatar'	=>	'',
	));
	$id = $d->getmax('u_id','member');
$d->Query("INSERT INTO `permissions` VALUES('$id' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' );");  
}
$d->Query("DROP TABLE IF  EXISTS `admin`");
$d->Query("ALTER TABLE `block` ADD `order` INT( 10 ) NOT NULL ,
ADD `module` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ");
$d->Query("ALTER TABLE `cat` ADD `enname` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD `img` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
ADD `sub` INT( 10 ) NOT NULL ");
$d->Query("ALTER TABLE `cat` CHANGE `ca_id` `id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
CHANGE `cat_title` `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ");
$d->Query("CREATE TABLE IF NOT EXISTS `catpost` (
  `catid` int(11) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$d->Query("ALTER TABLE `comments` ADD `email` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD `ans` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD `memberid` INT( 10 ) NOT NULL DEFAULT '-1',
ADD `active` INT( 1 ) NOT NULL ,
ADD `ansid` INT( 10 ) NOT NULL ");
$d->Query("ALTER TABLE `data` ADD `pos` INT( 11 ) NOT NULL ,
ADD `entitle` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD `timage` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD `context` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD `show` INT( 1 ) NOT NULL ,
ADD `scomments` INT( 1 ) NOT NULL ,
ADD `star` INT( 1 ) NOT NULL DEFAULT '1',
ADD `expire` VARCHAR( 10 ) NOT NULL ,
ADD `pass1` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD `pass2` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ");
$d->Query("ALTER TABLE `extra` ADD `users` INT( 1 ) NOT NULL DEFAULT '2'");
$d->Query("CREATE TABLE `keys` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET ucs2 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"); 
$d->Query("CREATE TABLE `keys_join` (
  `key_id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8"); 
$d->Query("ALTER TABLE `link` ADD `hits` INT( 5 ) NOT NULL DEFAULT '0'");
$d->Query("CREATE TABLE `menus` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `oid` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8"); 
$d->Query("INSERT INTO `menus` VALUES('1' , '0' , 'index' , 'صفحه اصلی مديريت' , 'index.php' , '0' );"); 
$d->Query("INSERT INTO `menus` VALUES('2' , '1' , 'newpost' , 'ارسال مطلب' , 'new.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('3' , '2' , 'postmgr' , 'مديـريـت مطالب' , 'postmgr.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('4' , '3' , 'comment' , 'مديريت نظرات
' , 'comment.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('5' , '4' , 'cat' , 'دسته بندي' , 'cat.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('8' , '5' , 'block' , 'مديريت بلوك ها  ' , 'block.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('9' , '6' , 'extra' , 'مديريت صفحات اضافي' , 'extra.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('10' , '7' , 'member' , 'مديريت اعضا' , 'member.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('11' , '11' , 'inbox' , 'صــنـدوق پـيـام هـا' , 'inbox.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('12' , '12' , 'uc' , 'مركز آپلود' , 'uc.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('13' , '13' , 'banned' , 'ليست سياه' , 'banned.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('14' , '14' , 'newsletter' , 'خبرنامه' , 'newsletter.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('15' , '15' , 'backup' , 'پشتيبان گيري' , 'backup.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('17' , '16' , 'template' , 'انتخاب قالب' , 'template.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('18' , '17' , 'setting' , 'تـنـظـيـمـات سـايـت' , 'setting.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('19' , '18' , 'update' , 'بروز رساني' , 'update.php' , '0' );"); 
$d->Query("INSERT INTO `menus` VALUES('20' , '19' , 'about' , 'درباره راش سي ام اس' , 'http://rashcms.ir/about/' , '2' );"); 
$d->Query("INSERT INTO `menus` VALUES('21' , '8' , 'permission' , 'اختيارات كاربران' , 'permission.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('22' , '10' , 'module' , 'ماژول ها' , 'module.php' , '1' );"); 
$d->Query("INSERT INTO `menus` VALUES('23' , '9' , 'simplelink' , 'لينكدوني' , 'simplelink.php' , '1' );");  
$d->Query("CREATE TABLE `module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `stat` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8"); 
$d->Query("INSERT INTO `module` VALUES('1' , 'author' , 'نويسنگان' , '1' );"); 
$d->Query("INSERT INTO `module` VALUES('3' , 'extra' , 'صفحات اضافي' , '1' );"); 
$d->Query("INSERT INTO `module` VALUES('4' , 'counter' , 'شمارنده' , '1' );"); 
$d->Query("INSERT INTO `module` VALUES('5' , 'cat' , 'موضوعات' , '1' );"); 
$d->Query("INSERT INTO `module` VALUES('6' , 'newsletter' , 'خبرنامه' , '1' );"); 
$d->Query("INSERT INTO `module` VALUES('7' , 'contact' , 'ارتباط با ما' , '9' );"); 
$d->Query("INSERT INTO `module` VALUES('8' , 'member' , 'سيستم كاربري' , '1' );"); 
$d->Query("INSERT INTO `module` VALUES('9' , 'module' , 'ماژول ها' , '1' );"); 
$d->Query("INSERT INTO `module` VALUES('10' , 'simplelink' , 'لينكدوني' , '1' );");  
$d->Query("CREATE TABLE `setting` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `site` varchar(255) NOT NULL,
  `seo` int(1) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `admintheme` varchar(255) NOT NULL,
  `tries` int(2) NOT NULL COMMENT 'number of tries to show security image for login',
  `sitetitle` varchar(255) CHARACTER SET ucs2 NOT NULL,
  `dtype` varchar(255) NOT NULL,
  `dzone` varchar(255) NOT NULL,
  `new_member` int(1) NOT NULL,
  `user_list` int(1) NOT NULL,
  `min_user_length` int(1) NOT NULL,
  `min_pass_length` int(1) NOT NULL,
  `send_pm` int(1) NOT NULL,
  `send_post` int(1) NOT NULL,
  `allow_types` text NOT NULL,
  `max_file_size` int(5) NOT NULL,
  `random_name` int(1) NOT NULL,
  `max_combined_size` int(10) NOT NULL,
  `file_uploads` int(2) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `lic` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `num` int(5) NOT NULL,
  `nlast` int(5) NOT NULL,
  `keys` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `adisable` int(1) NOT NULL DEFAULT '1',
  `disable` int(1) NOT NULL DEFAULT '1',
  `member` int(1) NOT NULL,
  `comment` int(1) NOT NULL,
  `member_area` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8"); 
$d->Query("INSERT INTO `setting` VALUES('1' , '$config[site]' , '2' , 'blue' , 'rashcms' , '3' , '$config[sitetitle]' , '$config[dtype]' , '$config[tzone]' , '1' , '2' , '7' , '5' , '2' , '2' , 'jpg,gif,zip,rar,txt,' , '30720' , '2' , '30720' , '3' , 'uploads' , '' , '$config[Email]' , '10' , '25' , '$config[sitedes]' , '$config[sitedes]' , '1' , '0' , '1' , '1' , '1' );");  
?>