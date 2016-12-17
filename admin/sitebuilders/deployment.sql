-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.22-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema tornado
--

CREATE DATABASE IF NOT EXISTS __SCHEMA__;
USE __SCHEMA__;

--
-- Definition of table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `year` int(10) unsigned NOT NULL,
  `month` int(10) unsigned NOT NULL,
  `day` int(10) unsigned NOT NULL,
  `json` text NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar`
--

/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;


--
-- Definition of table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `category` text NOT NULL,
  `date_added` int(10) unsigned NOT NULL,
  `items_left` int(11) NOT NULL default '-1' COMMENT '-1 = unlimited',
  `image_url` text NOT NULL COMMENT 'image base filename',
  `misc` text NOT NULL COMMENT '{json}, misc description',
  `json` text,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` (`key`,`name`,`description`,`price`,`category`,`date_added`,`items_left`,`image_url`,`misc`,`json`) VALUES 
 (2,'Woman parrot','This is a photograph of a woman painted as a parrot.',2.75,'Photograph',1435878245,1199,'','',NULL),
 (31,'A print of some kinds','description',0,'Print',1395680642,10000,'','',NULL),
 (45,'Persistence of memory - 1931','description',0,'Painting',1395681333,10000,'','',NULL),
 (47,'Drawing of a tractor','description',0,'Drawing',1395708593,10000,'','',NULL);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;


--
-- Definition of table `cart_cat`
--

DROP TABLE IF EXISTS `cart_cat`;
CREATE TABLE `cart_cat` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='cart categories...';

--
-- Dumping data for table `cart_cat`
--

/*!40000 ALTER TABLE `cart_cat` DISABLE KEYS */;
INSERT INTO `cart_cat` (`key`,`name`) VALUES 
 (1,'Extentions'),
 (2,'Adhesive'),
 (3,'Application Tools'),
 (4,'After Care');
/*!40000 ALTER TABLE `cart_cat` ENABLE KEYS */;


--
-- Definition of table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `dir` varchar(64) NOT NULL COMMENT 'category in url: eg: ''tutorials'', ''book reviews''',
  `name` varchar(64) NOT NULL COMMENT 'Tutorials, Book Reviews, etc.',
  `description` text NOT NULL COMMENT 'Description of this channel',
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`key`,`dir`,`name`,`description`) VALUES 
 (3,'html','HTML',''),
 (10,'miscellaneous','Miscellaneous',' ');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


--
-- Definition of table `categories2`
--

DROP TABLE IF EXISTS `categories2`;
CREATE TABLE `categories2` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `dir` text NOT NULL,
  `name` text NOT NULL COMMENT 'short name',
  `long_name` text NOT NULL COMMENT 'long div title',
  `priority` int(10) unsigned NOT NULL COMMENT 'display_priority',
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Sub-categories';

--
-- Dumping data for table `categories2`
--

/*!40000 ALTER TABLE `categories2` DISABLE KEYS */;
INSERT INTO `categories2` (`key`,`category_id`,`dir`,`name`,`long_name`,`priority`) VALUES 
 (1,1,'dir_name_one','first directory','Long first directory name',0),
 (2,1,'dir_name_two','second directory','Long second directory name',0);
/*!40000 ALTER TABLE `categories2` ENABLE KEYS */;


--
-- Definition of table `content-details`
--

DROP TABLE IF EXISTS `content-details`;
CREATE TABLE `content-details` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `article-id` int(10) unsigned NOT NULL,
  `data` varchar(45) NOT NULL COMMENT 'json',
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='content detail table';

--
-- Dumping data for table `content-details`
--

/*!40000 ALTER TABLE `content-details` DISABLE KEYS */;
/*!40000 ALTER TABLE `content-details` ENABLE KEYS */;


--
-- Definition of table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `type` varchar(16) NOT NULL,
  `location` text NOT NULL,
  `article` text NOT NULL COMMENT 'HTML-rasterized article',
  `title` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `image` text NOT NULL,
  `image_description` text NOT NULL,
  `template` varchar(255) default 'minimalist.php' COMMENT 'Name of the PHP template to use for this article',
  `category` varchar(255) character set latin1 collate latin1_bin default NULL COMMENT 'Main category of this article',
  `aweber_article_settings_id` int(10) unsigned NOT NULL default '1' COMMENT 'Default:1; The selected aweber sign-up forms settings for this article. Key id of an entry from `aweber_article_settings`',
  `browser_title` text NOT NULL,
  `facebook_msg` text NOT NULL COMMENT '200-300 characters',
  `twitter_msg` text NOT NULL COMMENT '140 characters',
  `article_plaintext` text NOT NULL COMMENT 'plain/text version of the article',
  `last_updated_time` int(10) NOT NULL COMMENT 'Time this article was last updated',
  `draft` tinyint(3) unsigned NOT NULL default '1' COMMENT 'Is this a draft? Always a draft by default.',
  `hidden` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Is this article hidden from the site? Default: 0 (no)',
  `deleted` int(10) unsigned NOT NULL default '0' COMMENT 'Deleted article (safe delete)',
  `publish_settings` text NOT NULL COMMENT 'JSON containing all entry id''s from  publish_target',
  `subcategory` text NOT NULL,
  `scheduled` text NOT NULL COMMENT 'Scheduled time',
  `javascript` text NOT NULL,
  `css` text NOT NULL,
  `noindexnofollow` tinyint(3) unsigned NOT NULL,
  `last_saved_time` int(10) unsigned NOT NULL,
  `navi` int(10) unsigned NOT NULL default '0' COMMENT 'include in site navigation?',
  `navi_order` int(10) unsigned NOT NULL default '0' COMMENT 'order on navigation bar',
  `navi_name` text NOT NULL COMMENT 'Navigation tab name',
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`key`,`type`,`location`,`article`,`title`,`keywords`,`description`,`time`,`image`,`image_description`,`template`,`category`,`aweber_article_settings_id`,`browser_title`,`facebook_msg`,`twitter_msg`,`article_plaintext`,`last_updated_time`,`draft`,`hidden`,`deleted`,`publish_settings`,`subcategory`,`scheduled`,`javascript`,`css`,`noindexnofollow`,`last_saved_time`,`navi`,`navi_order`,`navi_name`) VALUES 
 (1,'homepage','index.html','<p>If you are seeing this page you have successfully installed <a href=\"http://www.tornadoframework.net/\" title=\"Tornado PHP framework\">Tornado PHP Framework</a>, a simple website builder application. Below are some basic details about how Tornado works, and how you can start editing the website. By the way, we have included Tornado\'s official <a href=\"http://www.tornadoframework.net/t/wooden.html\">Wooden Template</a> for this installation, which is what you\'re looking at right now.</p><p><b>HTML Cache Makes Tornado Spin Fast</b></p><p>Tornado uses a simple and fast caching system, implemented through the Apache htaccess file to rasterize the file only. When a Tornado website is live, there are no Apache page rewrites at all. All content files are accessed as HTML, after being \"rasterized\" from PHP. There is absolutely no live PHP code used on the website, which makes it very fast to navigate. However, there is a layer of PHP that actually builds the header of a page and the template itself. This allows construction of the web templates in PHP.</p><p>Whenever you save a web page inside the article editor (press CTRL-S), or click on \"Save\" button, the PHP theme is \"rasterized\" as HTML, and the target html files are physically written into the root folder (if \"Page Type\" parameter for the article/web page is set to no_dir, webpage, or homepage.) If the \"Page Type\" parameter is set to any other folder, the folder will be created in website\'s file system (root) and the file will be saved in that folder.</p><p>The filename of each page can be changed in article editor\'s page settings (Location URI), and should use the .HTML extension. However, if you do use extension .PHP, it will not make a difference. Using HTML is probably faster, because it does not invoke the PHP processor at all.</p><p><b>Default Theme</b></p><p>You may see the \"wooden\" theme applied to this page in order to make sure everything works correctly. The theme for entire site or each article individually can be changed in admin editor. This, as most of everything else, is done on the same page where you are editing the article and can see the article preview. Tornado is a platform that tries to display all editing options on one page, so that the user doesn\'t have to flip around a lot of settings pages.</p>','Welcome to Your Homepage','home, page, house','homepage of..',0,'','','wooden','',1,'Welcome','','','If you are seeing this page you have successfully installed <a href = \"http://www.tornadoframework.net/\" title = \"Tornado PHP framework\">Tornado PHP Framework</a>, a simple website builder application. Below are some basic details about how Tornado works, and how you can start editing the website. By the way, we have included Tornado\'s official <a href = \"http://www.tornadoframework.net/t/wooden.html\">Wooden Template</a> for this installation, which is what you\'re looking at right now.\n\n<b>HTML Cache Makes Tornado Spin Fast</b>\n\nTornado uses a simple and fast caching system, implemented through the Apache htaccess file to rasterize the file only. When a Tornado website is live, there are no Apache page rewrites at all. All content files are accessed as HTML, after being \"rasterized\" from PHP. There is absolutely no live PHP code used on the website, which makes it very fast to navigate. However, there is a layer of PHP that actually builds the header of a page and the template itself. This allows construction of the web templates in PHP.\n\nWhenever you save a web page inside the article editor (press CTRL-S), or click on \"Save\" button, the PHP theme is \"rasterized\" as HTML, and the target html files are physically written into the root folder (if \"Page Type\" parameter for the article/web page is set to no_dir, webpage, or homepage.) If the \"Page Type\" parameter is set to any other folder, the folder will be created in website\'s file system (root) and the file will be saved in that folder.\n\nThe filename of each page can be changed in article editor\'s page settings (Location URI), and should use the .HTML extension. However, if you do use extension .PHP, it will not make a difference. Using HTML is probably faster, because it does not invoke the PHP processor at all.\n\n<b>Default Theme</b>\n\nYou may see the \"wooden\" theme applied to this page in order to make sure everything works correctly. The theme for entire site or each article individually can be changed in admin editor. This, as most of everything else, is done on the same page where you are editing the article and can see the article preview. Tornado is a platform that tries to display all editing options on one page, so that the user doesn\'t have to flip around a lot of settings pages.',1403048161,1,0,0,'0','','','','',0,1403048161,1,1,'Homepage'),
 (8,'webpage','example-2.html','<p>Example page 1</p>','Example Page','example,page','This is an example page',1,'','','wooden','',8,'Learning jQuery CSS Selectors','','','Example page 1',1403045519,0,0,0,'0','','','','',0,1403045519,1,4,'Example Tab 2'),
 (168,'webpage','draft-edf4768.472965806723.html','<p>Example unpublished draft (click blue icon with pencil on content editor page, in upper right to publish this draft).</p>','New Draft','jquery,html,elements,DOM,selectors,css','In this tutorial you will learn how to select HTML elements using CSS selectors and how jQuery CSS selectors relate to the HTML DOM (Document Object Model) object. CSS selectors are used to choose the branches of the DOM tree, in other words, select HTML elements by TAG name, ID or CLASS name. It is possible to select a list of elements using combinations of tag names (separated by commas.) Once an HTML element or a series of elements are selected we can apply a jQuery method on this selection to modify the appearance of selected HTML, add elements within others, or remove an element from the DOM (from your web page) completely. There are many ways in which jQuery can be used to manipulate HTML elements using CSS selectors. This is the first part of the two-part tutorial about CSS selectors.',1401897204,'','','wooden','',1,'An example draft page','','','Example unpublished draft (click blue icon with pencil on content editor page, in upper right to publish this draft).',1401994401,1,0,1,'0','','No','','',1,1401994401,0,0,''),
 (169,'webpage','example-1.html','<p><b>This is an example content page.</b></p><p>World Maker is a 3D utility tool for building 3D worlds for Kaleidoscope games. It works much like your standard 3D modeling software, except it simplified specifically for using with Kaleidoscope games.</p><p>Upon opening the software, you are greeted by four standard views of the 3d world from 3 different angles and one for free camera perspective view. By navigating the world from different angles and clicking the mouse it is possible to add 3 dimensional shapes such as cubes or rectangles to the scene. Each polygon can then be adjusted by its tips (vertices). This is the only tool used to create the game worlds in all games developed by Kaleidoscope.\n</p>','World Maker','kw1, kw2, kw3','meta descr',1401919249,'','','wooden','',1,'Example','','','«This is an example content page.»\n\nWorld Maker is a 3D utility tool for building 3D worlds for Kaleidoscope games. It works much like your standard 3D modeling software, except it simplified specifically for using with Kaleidoscope games.\n\nUpon opening the software, you are greeted by four standard views of the 3d world from 3 different angles and one for free camera perspective view. By navigating the world from different angles and clicking the mouse it is possible to add 3 dimensional shapes such as cubes or rectangles to the scene. Each polygon can then be adjusted by its tips (vertices). This is the only tool used to create the game worlds in all games developed by Kaleidoscope.\n',1403045712,0,0,0,'0','','No','','',1,1403045712,0,5,'Example Tab'),
 (170,'webpage','draft.html','<p>Example page 1a</p>','Example Page','example,page','This is an example page',1402636651,'','','wooden','',1,'Learning jQuery CSS Selectors','','','Example page 1a',1403030768,1,0,1,'0','','No','','',1,1403030768,0,9,''),
 (171,'webpage','contact.html','<p></p><form action=\"contactsent.php\" method=\"post\" id=\"submit\">\n                <table style=\"margin-top: 16px;\">\n                    <tbody><tr><td>Name:</td><td><input type=\"text\" name=\"name\" id=\"name\"></td></tr>\n                    <tr><td>Email Address:</td><td><input type=\"text\" name=\"email\" id=\"email\"> required</td></tr>\n                    <tr><td>Phone#:</td><td><input type=\"text\" name=\"phone\" id=\"phone\"> optional; include only if you prefer us to contact you by phone</td></tr>\n                    <tr><td></td><td>Your message:<br><textarea name=\"message\" style=\"width: 500px; height: 150px;\"></textarea></td></tr>\n                    <tr><td></td><td><input type=\"submit\" id=\"send\" value=\"Send Message\" onclick=\"this.value = \'Please Wait...\';\"><span id=\"cmsg\"></span></td></tr>\n                </tbody></table>\n            </form>\n<p></p>','Contact','contact','contact',1402638336,'','','wooden','',1,'Contact','','','<form action = \"contactsent.php\" method = \"post\" id = \"submit\">\n                <table style = \"margin-top: 16px;\">\n                    <tr><td>Name:</td><td><input type = \"text\" name = \"name\" id = \"name\" /></td></tr>\n                    <tr><td>Email Address:</td><td><input type = \"text\" name = \"email\" id = \"email\" /> required</td></tr>\n                    <tr><td>Phone#:</td><td><input type = \"text\" name = \"phone\" id = \"phone\" /> optional; include only if you prefer us to contact you by phone</td></tr>\n                    <tr><td></td><td>Your message:<br/><textarea name = \"message\" style = \"width: 500px; height: 150px;\"></textarea></td></tr>\n                    <tr><td></td><td><input type = \"submit\" id = \"send\" value = \"Send Message\" onclick = \"this.value = \'Please Wait...\';\" /><span id = \"cmsg\"></span></td></tr>\n                </table>\n            </form>\n',1403036364,0,0,0,'0','','No','','table textarea, table input[type=text] {margin:0; padding:4px;background:black; border:1px solid gray; color: white;}',1,1403036364,1,7,'Contact Us'),
 (172,'webpage','games.html','<p>This could be a collection of games produced by your video game company, a list of songs, or an art gallery, etc.</p><p>racing game...</p><p>survival game...</p><p>some, other game...</p>','Games','games','games',1402638584,'','','wooden','',1,'Games','','','This could be a collection of games produced by your video game company, a list of songs, or an art gallery, etc.\n\nracing game...\n\nsurvival game...\n\nsome, other game...',1403036337,0,0,0,'0','','No','','',1,1403036337,1,3,'Games'),
 (173,'webpage','about.html','<p>About This Website...</p>','about','about','about',1402638815,'','','wooden','',1,'about','','','About This Website...',1403049520,0,0,0,'0','','No','','',1,1403049520,1,6,'About Us'),
 (174,'webpage','contact.html','<p></p><form action=\"contactsent.php\" method=\"post\" id=\"submit\">\n                <table style=\"margin-top: 16px;\">\n                    <tbody><tr><td>Name:</td><td><input type=\"text\" name=\"name\" id=\"name\"></td></tr>\n                    <tr><td>Email Address:</td><td><input type=\"text\" name=\"email\" id=\"email\"> required</td></tr>\n                    <tr><td>Phone#:</td><td><input type=\"text\" name=\"phone\" id=\"phone\"> optional; include only if you prefer me to contact you by phone</td></tr>\n                    <tr><td></td><td>Your message:<br><textarea name=\"message\" style=\"width: 500px; height: 150px;\"></textarea></td></tr>\n                    <tr><td></td><td><input type=\"submit\" id=\"send\" value=\"Send Message\" onclick=\"this.value = \'Please Wait...\';\"><span id=\"cmsg\"></span></td></tr>\n                </tbody></table>\n            </form>\n<p></p>','Contact Kaleidoscope Games','contact','contact',1402639229,'','','wooden','',1,'Contact Kaleidoscope Games','','','<form action = \"contactsent.php\" method = \"post\" id = \"submit\">\n                <table style = \"margin-top: 16px;\">\n                    <tr><td>Name:</td><td><input type = \"text\" name = \"name\" id = \"name\" /></td></tr>\n                    <tr><td>Email Address:</td><td><input type = \"text\" name = \"email\" id = \"email\" /> required</td></tr>\n                    <tr><td>Phone#:</td><td><input type = \"text\" name = \"phone\" id = \"phone\" /> optional; include only if you prefer me to contact you by phone</td></tr>\n                    <tr><td></td><td>Your message:<br/><textarea name = \"message\" style = \"width: 500px; height: 150px;\"></textarea></td></tr>\n                    <tr><td></td><td><input type = \"submit\" id = \"send\" value = \"Send Message\" onclick = \"this.value = \'Please Wait...\';\" /><span id = \"cmsg\"></span></td></tr>\n                </table>\n            </form>\n',1402698893,1,0,1,'0','','No','','',1,1402698893,0,0,''),
 (175,'webpage','blog.html','<p>This is an example blog list page. Here you will see a listing of all blogs.</p><p>World Maker is a 3D utility tool for building 3D worlds for Kaleidoscope games. It works much like your standard 3D modeling software, except it simplified specifically for using with Kaleidoscope games.</p><p>Upon opening the software, you are greeted by four standard views of the 3d world from 3 different angles and one for free camera perspective view. By navigating the world from different angles and clicking the mouse it is possible to add 3 dimensional shapes such as cubes or rectangles to the scene. Each polygon can then be adjusted by its tips (vertices). This is the only tool used to create the game worlds in all games developed by Kaleidoscope.</p>','Blog','example,page','example blog',1402684142,'','','wooden','',1,'Blog','','','This is an example blog list page. Here you will see a listing of all blogs.\n\nWorld Maker is a 3D utility tool for building 3D worlds for Kaleidoscope games. It works much like your standard 3D modeling software, except it simplified specifically for using with Kaleidoscope games.\n\nUpon opening the software, you are greeted by four standard views of the 3d world from 3 different angles and one for free camera perspective view. By navigating the world from different angles and clicking the mouse it is possible to add 3 dimensional shapes such as cubes or rectangles to the scene. Each polygon can then be adjusted by its tips (vertices). This is the only tool used to create the game worlds in all games developed by Kaleidoscope.',1403048154,0,0,0,'0','','No','','',0,1403048154,1,2,'Blog'),
 (176,'webpage','testing-hp.html','<p>This is just a draft page. Do what you will with it. More than likely you want to <b>delete it</b>. Deleted pages are not deleted from the database, only flagged as deleted, so they can be looked up later, especially if you deleted a page by accident. It can be restored again!\n</p>','Draft Page Example','home, page, house','homepage of..',1403031205,'','','wooden','',1,'Homepage test','','','This is just a draft page. Do what you will with it. More than likely you want to «delete it». Deleted pages are not deleted from the database, only flagged as deleted, so they can be looked up later, especially if you deleted a page by accident. It can be restored again!\n',1403048197,1,0,0,'0','','No','','',1,1403048197,1,8,'Scratch'),
 (177,'webpage','draft-bgb6734.980943147093.html','<p>This is yet another draft page, just as an example. You can turn it into any type of page for your website, delete it, or start a new draft from it by clicking on \"Save as New Draft\". That will copy this page (including its content, and page configuration, except URI) into a new draft.</p>','new draft page','draft','draft',1403039455,'','','wooden','',1,'another draft','','','This is yet another draft page, just as an example. You can turn it into any type of page for your website, delete it, or start a new draft from it by clicking on \"Save as New Draft\". That will copy this page (including its content, and page configuration, except URI) into a new draft.',1403041732,1,0,0,'0','','No','','',1,1403041732,0,9,''),
 (178,'webpage','draft-aec5900.392583571374.html','<p>This is yet another draft page, just as an example. You can turn it into any type of page for your website, delete it, or start a new draft from it by clicking on \"Save as New Draft\". That will copy this page (including its content, and page configuration, except URI) into a new draft.</p>','new draft page','draft','draft',1403045273,'','','wooden','',1,'another draft','','','This is yet another draft page, just as an example. You can turn it into any type of page for your website, delete it, or start a new draft from it by clicking on \"Save as New Draft\". That will copy this page (including its content, and page configuration, except URI) into a new draft.',1403045273,1,0,1,'0','','No','','',1,1403045273,0,0,'');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;


--
-- Definition of table `email_to_a_friend`
--

DROP TABLE IF EXISTS `email_to_a_friend`;
CREATE TABLE `email_to_a_friend` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `sender` varchar(64) NOT NULL,
  `recipient` varchar(64) NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  `sender_name` text NOT NULL,
  `recipient_name` text NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_to_a_friend`
--

/*!40000 ALTER TABLE `email_to_a_friend` DISABLE KEYS */;
INSERT INTO `email_to_a_friend` (`key`,`sender`,`recipient`,`article_id`,`sender_name`,`recipient_name`) VALUES 
 (13,'dfdf','sdf3333sdf@gmail.com',133,'dfdf','dsfsfdf');
/*!40000 ALTER TABLE `email_to_a_friend` ENABLE KEYS */;


--
-- Definition of table `ipn`
--

DROP TABLE IF EXISTS `ipn`;
CREATE TABLE `ipn` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `transaction_id` varchar(255) NOT NULL COMMENT 'txn_id',
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `item_id` varchar(32) NOT NULL COMMENT 'Purchased item id',
  `payment` varchar(45) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ipn`
--

/*!40000 ALTER TABLE `ipn` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipn` ENABLE KEYS */;


--
-- Definition of table `msg_opens`
--

DROP TABLE IF EXISTS `msg_opens`;
CREATE TABLE `msg_opens` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `email_address` text NOT NULL,
  `msg_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msg_opens`
--

/*!40000 ALTER TABLE `msg_opens` DISABLE KEYS */;
/*!40000 ALTER TABLE `msg_opens` ENABLE KEYS */;


--
-- Definition of table `publish_target`
--

DROP TABLE IF EXISTS `publish_target`;
CREATE TABLE `publish_target` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `url` varchar(64) NOT NULL,
  `owner_name` varchar(64) NOT NULL,
  `email_address` text NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `type` text NOT NULL COMMENT 'own,guest,social(fb,tw,g+,pinterest)',
  `parameters` text NOT NULL COMMENT 'JSON containing whatever parameters are required',
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publish_target`
--

/*!40000 ALTER TABLE `publish_target` DISABLE KEYS */;
INSERT INTO `publish_target` (`key`,`name`,`url`,`owner_name`,`email_address`,`description`,`tags`,`type`,`parameters`) VALUES 
 (1,'Mailchimp newsletter','example1.com','MailChimp Newsletter','email1@example.com','Send out to MailChimp subscribers','none','mailchimp','{\"list_id\":1234567}'),
 (2,'Another website','example2.com','First Last','email2@example.com','Target description','tag1, tag2, tag3','guest','{}'),
 (6,'Website 3','example3.com','First Last','email3@example.com','Target description','kw1, kw2, kw3','rss','{}'),
 (11,'Twitter','twitter.com','Twitter',' ','Post on Twitter','twitter post','twitter','{}'),
 (12,'Facebook','facebook.com','Facebook',' ','Post on Facebook','facebook post','facebook','{}'),
 (13,'Google+','plus.google.com','Google, Inc.',' ','Post on Google Plus','google plus post','googleplus','{}'),
 (15,'Aweber','recipe-tutorials','Aweber',' ','Aweber','Aweber','aweber','{\"list_id\":1234567}');
/*!40000 ALTER TABLE `publish_target` ENABLE KEYS */;


--
-- Definition of table `publish_to`
--

DROP TABLE IF EXISTS `publish_to`;
CREATE TABLE `publish_to` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `target` text NOT NULL COMMENT 'e.g.: twitter.com, facebook.com, authenticsociety.com, email@address.com',
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Websites to publish this article on';

--
-- Dumping data for table `publish_to`
--

/*!40000 ALTER TABLE `publish_to` DISABLE KEYS */;
INSERT INTO `publish_to` (`key`,`target`) VALUES 
 (1,'twitter.com'),
 (2,'facebook.com'),
 (3,'plus.google.com'),
 (4,'example.com');
/*!40000 ALTER TABLE `publish_to` ENABLE KEYS */;


--
-- Definition of table `saved_publish_configs`
--

DROP TABLE IF EXISTS `saved_publish_configs`;
CREATE TABLE `saved_publish_configs` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `name` text NOT NULL,
  `json` text NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saved_publish_configs`
--

/*!40000 ALTER TABLE `saved_publish_configs` DISABLE KEYS */;
INSERT INTO `saved_publish_configs` (`key`,`name`,`json`) VALUES 
 (5,'test','{\"0\":{\"url\":\"example.com\", \"email\":\"example@gmail.com\", \"value_attr\": \"5\"}}'),
 (9,'default','{}');
/*!40000 ALTER TABLE `saved_publish_configs` ENABLE KEYS */;


--
-- Definition of table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `year` int(10) unsigned NOT NULL,
  `month` int(10) unsigned NOT NULL,
  `day` int(11) NOT NULL,
  `json` text NOT NULL,
  `sent` int(10) unsigned NOT NULL,
  `target` text NOT NULL,
  `date` varchar(45) NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;


--
-- Definition of table `search_results`
--

DROP TABLE IF EXISTS `search_results`;
CREATE TABLE `search_results` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `listing` text NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `search_results`
--

/*!40000 ALTER TABLE `search_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_results` ENABLE KEYS */;


--
-- Definition of table `divs`
--

DROP TABLE IF EXISTS `divs`;
CREATE TABLE `divs` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(64) NOT NULL COMMENT 'What appears on the navigation bar',
  `url` text NOT NULL COMMENT 'Full url to the page',
  `index` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Main site navigation divs';

--
-- Dumping data for table `divs`
--

/*!40000 ALTER TABLE `divs` DISABLE KEYS */;
INSERT INTO `divs` (`key`,`title`,`url`,`index`) VALUES
 (1,'Contact','contact.html',2),
 (2,'About','about.html',1),
 (3,'Homepage','',0),
 (5,'Privacy','privacy.html',3),
 (25,'Terms','terms.html',6);
/*!40000 ALTER TABLE `divs` ENABLE KEYS */;


--
-- Definition of table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `user` varchar(32) NOT NULL default '',
  `email_address` varchar(32) NOT NULL default '',
  `status` tinyint(4) NOT NULL default '0',
  `expires_on` int(11) NOT NULL default '0',
  `last_page_url` varchar(255) NOT NULL default '',
  `last_page_opened_on` int(11) NOT NULL default '0',
  `seconds_spent_online` int(11) NOT NULL default '0',
  `logged_in_times` int(11) NOT NULL default '0',
  `display_name` varchar(32) NOT NULL default '',
  `ip_haystack` text NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;


--
-- Definition of table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `virtual-folder` varchar(255) NOT NULL COMMENT 'virtual content folder, e.g.: about, article, content, etc.',
  `web-template` varchar(255) NOT NULL,
  `bottom-content-1` text COMMENT 'Website bottom: content-1 (recommended, etc. links)',
  `bottom-content-2` text COMMENT 'Website bottom: content-2 (newsletter sign up, large box)',
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Site settings';

--
-- Dumping data for table `settings`
--

/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`key`,`title`,`slogan`,`virtual-folder`,`web-template`,`bottom-content-1`,`bottom-content-2`) VALUES 
 (1,'Website name','Website slogan: The simple encyclopedia','webpage','wooden','','');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;


--
-- Definition of table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE `subscribers` (
  `key` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `email_address` varchar(255) default NULL,
  `list_id` int(10) default NULL,
  `timestamp` int(10) default NULL,
  `date` text,
  `json` text,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribers`
--

/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;


--
-- Definition of table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `email_address` varchar(64) NOT NULL default '',
  `password` varchar(40) NOT NULL,
  `birthdate` int(10) unsigned NOT NULL default '0',
  `gender` varchar(6) NOT NULL default '',
  `first_name` varchar(16) NOT NULL default '',
  `last_name` varchar(16) NOT NULL default '',
  `display_name` varchar(32) NOT NULL default '',
  `country` varchar(128) NOT NULL,
  `state` varchar(16) NOT NULL default '',
  `creation_time` bigint(20) unsigned NOT NULL default '0',
  `last_login` int(10) unsigned NOT NULL default '0',
  `relationship` varchar(32) NOT NULL default '',
  `occupation` varchar(64) NOT NULL default '',
  `prefs` bigint(11) NOT NULL default '0',
  `authenticity` smallint(5) unsigned NOT NULL default '0',
  `bio` text NOT NULL,
  `stats_article_visitors` int(10) unsigned NOT NULL default '0',
  `wish_had_more` varchar(255) NOT NULL default '',
  `before_i_die` varchar(255) NOT NULL default '',
  `personality_type` tinyint(3) unsigned NOT NULL default '0',
  `community_list` varchar(255) NOT NULL default '',
  `mana` int(10) unsigned NOT NULL default '0',
  `visual_password` varchar(16) NOT NULL default '',
  `full_name` varchar(32) NOT NULL default '',
  `account_activation_code` varchar(16) NOT NULL default '0',
  `account_status` int(10) unsigned NOT NULL default '0',
  `city` varchar(64) NOT NULL default '0',
  `region` varchar(128) NOT NULL default '0',
  `last_feed_id` int(10) unsigned NOT NULL default '0',
  `has_image` int(10) unsigned NOT NULL default '0',
  `chatpos` varchar(32) default '0',
  `last_action_time` int(11) default NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Authentic Society user table';

--
-- Dumping data for table `user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
