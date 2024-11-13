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
@session_start();
$r = @file_get_contents('rashcms.lock');
if($r == '1')
die('Install is disabled !!');
if(@$_SESSION['step'] != 'admindbc')
die('WWW.RASHCMS.COM -- Wrong Access !!!');
mysql_query("CREATE TABLE `bann` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `mess` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1");  
mysql_query("CREATE TABLE `block` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `pos` int(1) NOT NULL,
  `users` int(1) NOT NULL,
  `module` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1"); 
mysql_query("INSERT INTO `block` VALUES('54' , '59' , 'شمارنده' , '[Counter]' , '4' , '2' , 'counter' );"); 
mysql_query("INSERT INTO `block` VALUES('78' , '64' , 'موضوعات' , '[Cats]' , '3' , '2' , 'cat' );"); 
mysql_query("INSERT INTO `block` VALUES('65' , '57' , 'اعضا' , '[Members_Area]' , '4' , '2' , 'member' );"); 
mysql_query("INSERT INTO `block` VALUES('69' , '61' , 'لينكستان' , '[links]' , '3' , '2' , 'simplelink' );"); 
mysql_query("INSERT INTO `block` VALUES('70' , '62' , 'صفحات اضافي' , '[Extra]' , '3' , '2' , 'extra' );"); 
mysql_query("INSERT INTO `block` VALUES('71' , '52' , 'نخست' , '<font class=\"content\">
<img src=\"template/main/blue/img/home.png\"></font><span lang=\"en-us\"> </span>
<a href=\"index.php\">صفحه 
اصلی</a><br>

<font class=\"content\">
<img src=\"template/main/blue/img/pm.png\"></font><span lang=\"en-us\"> </span>
<a href=\"index.php?module=contact\">ارتباط با ما</a> <br>

<font class=\"content\">
<img src=\"template/main/blue/img/users.gif\"></font><span lang=\"en-us\"> </span>
<a href=\"index.php?module=member&action=list\">كاربران</a> <br>

<font class=\"content\">
<img src=\"template/main/blue/img/reg.gif\"></font><span lang=\"en-us\"> </span>
<a href=\"index.php?module=member&action=register\">عضویت در سایت 
</a> <br>
<font class=\"content\">
<img src=\"template/main/blue/img/reg.gif\"></font><span lang=\"en-us\"> </span>
<a href=\"http://www.rashcms.com\">راش سي ام اس 
</a>
' , '3' , '2' , 'none' );"); 
mysql_query("INSERT INTO `block` VALUES('72' , '53' , 'خبرنامه' , '[Newsletter]' , '3' , '2' , 'newsletter' );"); 
mysql_query("INSERT INTO `block` VALUES('76' , '56' , 'نويسندگان' , '[Authors]' , '4' , '2' , 'author' );");  
mysql_query("CREATE TABLE `cat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `enname` varchar(256) NOT NULL,
  `sub` int(10) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8"); 
mysql_query("INSERT INTO `cat` VALUES('31' , 'عمومي' , 'general' , '0' , '' );"); 
mysql_query("INSERT INTO `cat` VALUES('32' , 'عمومي' , 'general' , '31' , '' );");  
mysql_query("CREATE TABLE `catpost` (
  `catid` int(11) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8"); 
mysql_query("INSERT INTO `catpost` VALUES('31' , '10' );");  
mysql_query("CREATE TABLE `comments` (
  `c_id` int(8) NOT NULL AUTO_INCREMENT,
  `p_id` int(8) NOT NULL,
  `c_author` varchar(255) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `date` int(14) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ans` text CHARACTER SET utf8 NOT NULL,
  `memberid` int(10) NOT NULL DEFAULT '-1' COMMENT 'a user who send message',
  `active` int(1) NOT NULL,
  `ansid` int(10) NOT NULL COMMENT 'a manager who answer',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1"); 
mysql_query("INSERT INTO `comments` VALUES('20' , '10' , 'رضا شاهرخيان' , 'سلام
اين كامنت براي  تست ارسال شده است !
سيستم مديريت محتواي راش
www.rashcms.comr
www.forum.rashcms.com' , '1284478037' , '127.0.0.1' , 'http://rashcms.com' , 'rashcms@gmail.com' , '' , '-1' , '0' , '0' );");  
mysql_query("CREATE TABLE `counter` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `total` int(30) NOT NULL,
  `todaycounts` int(30) NOT NULL,
  `yescounts` int(30) NOT NULL,
  `month` int(30) NOT NULL,
  `year` int(30) NOT NULL,
  `lastyear` int(11) NOT NULL,
  `cdate` date NOT NULL,
  `lastmonth` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1"); 
$cudate          = date( "Y-m-d" );
mysql_query("INSERT INTO `counter` VALUES('1' , '1' , '1' , '0' , '1' , '1' , '0' , '$cudate ' , '0' );");  
mysql_query("CREATE TABLE `data` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `pos` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `entitle` varchar(255) CHARACTER SET utf8 NOT NULL,
  `timage` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cat_id` int(4) NOT NULL,
  `author` int(10) NOT NULL,
  `context` varchar(255) DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `show` int(1) NOT NULL DEFAULT '1',
  `scomments` int(1) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0',
  `star` int(1) NOT NULL DEFAULT '1',
  `expire` varchar(10) NOT NULL,
  `date` varchar(10) NOT NULL,
  `pass1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pass2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `reg` varchar(255) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `full` text CHARACTER SET utf8,
  `tvote` int(10) NOT NULL DEFAULT '0',
  `nov` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=ucs2"); 
mysql_query("INSERT INTO `data` VALUES('10' , '10' , 'خوش آمديد!' , 'welcome' , 'http://rashcms.com/logo.png' , '32' , '1' , 'ادامه مطلب' , '0' , '1' , '1' , '1' , '1' , '0' , '1284476978' , '' , '' , '1' , '<p>سلام<br>از انتخاب شما سپاسگذاريم !<br>شما هم اكنون در حال مشاهده پست پيش فرض سيستم هستيد.<br>براي حذف يا ويرايش اين پست ميتوانيد از بخش مديريت اقدام كنيد.</p>
<center><a target=\"_blank\" href=\"http://www.rashcms.com\">وب سايت سيستم 
مديريت محتواي راش </a>-- 
<a target=\"_blank\" href=\"http://www.forum.rashcms.com\">انجمن 
پشتيباني راش سي ام اس </a>--
<a target=\"_blank\" href=\"http://www.rashcms.ir\">سامانه نظر سنجي 
راش</a>&nbsp; --
<a target=\"_blank\" href=\"http://www.rashcms.ir/about\">درباره راش</a>
<br>
</center>' , '' , '5' , '1' );");  
mysql_query("CREATE TABLE `extra` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `users` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1");  
mysql_query("CREATE TABLE `keys` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET ucs2 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"); 
mysql_query("CREATE TABLE `keys_join` (
  `key_id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8"); 
mysql_query("CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `des` text CHARACTER SET utf8 NOT NULL,
  `hits` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1"); 
mysql_query("INSERT INTO `link` VALUES('1' , 'سيستم مديريت محتواي راش' , 'http://rashcms.com/' , 'سيستم مديريت محتواي راش' , '0' );"); 
mysql_query("INSERT INTO `link` VALUES('2' , 'سامانه نظر سنجي راش سي ام اس' , 'http://rashcms.ir' , 'سامانه نظر سنجي راش سي ام اس' , '0' );"); 
mysql_query("INSERT INTO `link` VALUES('3' , 'سيستم افزايش آمار هوشمند مجيك' , 'http://dir.magictools.ir' , 'سيستم افزايش آمار هوشمند مجيك' , '0' );"); 
mysql_query("INSERT INTO `link` VALUES('4' , 'شبكه آموزش پارسيان' , 'http://educator.ir' , 'شبكه آموزش پارسيان' , '0' );"); 
mysql_query("INSERT INTO `link` VALUES('5' , 'انجمن پشتيباني راش سي ام اس' , 'http://forum.rashcms.com' , 'انجمن پشتيباني راش سي ام اس' , '0' );");  
mysql_query("CREATE TABLE `member` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `prv`  varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pass` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yid` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'yahoo id',
  `gid` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'google id',
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `about` text CHARACTER SET utf8 NOT NULL,
  `showname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tell` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(255) NOT NULL,
  `stat` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1"); 
$md5 = md5(sha1(@$_POST['admin_pass']));
$user= @$_POST['admin_user'];
mysql_query("INSERT INTO `member` VALUES('1' , '' , 'مديريت' , '$user' , '$md5' , '123' , '127.0.0.1' , 'rashcms@gmail.com' , 'rashcms' , '$email' , '' , '' , '' , '' , 'FF33CC' , '1' );") or die(mysql_error());  
mysql_query("CREATE TABLE `menus` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `oid` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8"); 
mysql_query("INSERT INTO `menus` VALUES('1' , '0' , 'index' , 'صفحه اصلی مديريت' , 'index.php' , '0' );"); 
mysql_query("INSERT INTO `menus` VALUES('2' , '1' , 'newpost' , 'ارسال مطلب' , 'new.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('3' , '2' , 'postmgr' , 'مديـريـت مطالب' , 'postmgr.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('4' , '3' , 'comment' , 'مديريت نظرات
' , 'comment.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('5' , '4' , 'cat' , 'دسته بندي' , 'cat.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('8' , '5' , 'block' , 'مديريت بلوك ها  ' , 'block.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('9' , '6' , 'extra' , 'مديريت صفحات اضافي' , 'extra.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('10' , '7' , 'member' , 'مديريت اعضا' , 'member.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('11' , '11' , 'inbox' , 'صــنـدوق پـيـام هـا' , 'inbox.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('12' , '12' , 'uc' , 'مركز آپلود' , 'uc.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('13' , '13' , 'banned' , 'ليست سياه' , 'banned.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('14' , '14' , 'newsletter' , 'خبرنامه' , 'newsletter.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('15' , '15' , 'backup' , 'پشتيبان گيري' , 'backup.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('17' , '16' , 'template' , 'انتخاب قالب' , 'template.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('18' , '17' , 'setting' , 'تـنـظـيـمـات سـايـت' , 'setting.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('19' , '18' , 'update' , 'بروز رساني' , 'update.php' , '0' );"); 
mysql_query("INSERT INTO `menus` VALUES('20' , '19' , 'about' , 'درباره راش سي ام اس' , 'http://rashcms.ir/about/' , '2' );"); 
mysql_query("INSERT INTO `menus` VALUES('21' , '8' , 'permission' , 'اختيارات كاربران' , 'permission.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('22' , '10' , 'module' , 'ماژول ها' , 'module.php' , '1' );"); 
mysql_query("INSERT INTO `menus` VALUES('23' , '9' , 'simplelink' , 'لينكدوني' , 'simplelink.php' , '1' );");  
mysql_query("CREATE TABLE `module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `stat` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8"); 
mysql_query("INSERT INTO `module` VALUES('1' , 'author' , 'نويسنگان' , '1' );"); 
mysql_query("INSERT INTO `module` VALUES('3' , 'extra' , 'صفحات اضافي' , '1' );"); 
mysql_query("INSERT INTO `module` VALUES('4' , 'counter' , 'شمارنده' , '1' );"); 
mysql_query("INSERT INTO `module` VALUES('5' , 'cat' , 'موضوعات' , '1' );"); 
mysql_query("INSERT INTO `module` VALUES('6' , 'newsletter' , 'خبرنامه' , '1' );"); 
mysql_query("INSERT INTO `module` VALUES('7' , 'contact' , 'ارتباط با ما' , '9' );"); 
mysql_query("INSERT INTO `module` VALUES('8' , 'member' , 'سيستم كاربري' , '1' );"); 
mysql_query("INSERT INTO `module` VALUES('9' , 'module' , 'ماژول ها' , '1' );"); 
mysql_query("INSERT INTO `module` VALUES('10' , 'simplelink' , 'لينكدوني' , '1' );");  
mysql_query("CREATE TABLE `msg` (
  `pm_id` int(11) NOT NULL AUTO_INCREMENT,
  `reade` int(3) NOT NULL DEFAULT '0',
  `send_id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`pm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1");  
mysql_query("CREATE TABLE `nl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1"); 
mysql_query("CREATE TABLE `nls` (
  `SmtpHost` varchar(255) NOT NULL,
  `SmtpUser` varchar(255) NOT NULL,
  `SmtpPassword` varchar(255) NOT NULL,
  `mailperpack` varchar(255) NOT NULL DEFAULT '20',
  `msperpack` varchar(255) NOT NULL DEFAULT '10'
) ENGINE=MyISAM DEFAULT CHARSET=latin1"); 
mysql_query("INSERT INTO `nls` VALUES('' , '' , '' , '' , '' );");  
mysql_query("CREATE TABLE `onlines` (
  `time` int(11) NOT NULL,
  `session` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1"); 
mysql_query("CREATE TABLE `permissions` (
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
mysql_query("INSERT INTO `permissions` VALUES('1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' , '1' );");  
mysql_query("CREATE TABLE `setting` (
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
mysql_query("INSERT INTO `setting` VALUES('1' , '$site' , '2' , 'blue' , 'rashcms' , '3' , 'راش سی ام اس' , 'l j F Y' , '3.5' , '1' , '2' , '7' , '5' , '2' , '2' , 'jpg,gif,zip,rar,txt,' , '30720' , '2' , '30720' , '3' , 'uploads' , '' , '$email' , '10' , '25' , 'كلمات كليدي  :' , 'توضيحات :' , '1' , '0' , '1' , '1' , '1' );");  
?>