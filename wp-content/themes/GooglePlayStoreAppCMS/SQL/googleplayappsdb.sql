# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.36)
# Database: appmarketcms
# Generation Time: 2017-10-18 02:34:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activations`;

CREATE TABLE `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `activations` WRITE;
/*!40000 ALTER TABLE `activations` DISABLE KEYS */;

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`)
VALUES
	(1,1,'tkxvCJPVmvrf31v3j8NXQgMhRG3aP4QA',1,'2017-09-08 16:25:56','2017-09-08 16:25:56','2017-09-08 16:25:56');

/*!40000 ALTER TABLE `activations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table advertisement_blocks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `advertisement_blocks`;

CREATE TABLE `advertisement_blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` text COLLATE utf8_unicode_ci NOT NULL,
  `is_demo` int(11) NOT NULL DEFAULT '0' COMMENT '1 means its in demo,  0 if its in live mode',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `advertisement_blocks` WRITE;
/*!40000 ALTER TABLE `advertisement_blocks` DISABLE KEYS */;

INSERT INTO `advertisement_blocks` (`id`, `identifier`, `title`, `code`, `is_demo`, `created_at`, `updated_at`)
VALUES
	(1,'sidebar','SideBarAds','Sidebar Ads Here',0,'2017-09-08 03:14:58','2017-09-08 03:14:58'),
	(2,'leaderboard','LeaderBoard in All Pages','LeaderBoard Ads Here',0,'2017-09-08 03:16:16','2017-09-08 03:16:16'),
	(3,'ads_content','Ads Between Contents','Ads Between Contents',0,'2017-09-08 03:17:40','2017-09-08 03:17:40'),
	(4,'footer_ads','Footer Ads Index Page Only','Footer Ads Index Page Only',0,'2017-09-08 06:38:44','2017-09-08 06:38:44');

/*!40000 ALTER TABLE `advertisement_blocks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_market_reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_market_reviews`;

CREATE TABLE `app_market_reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `app_market_id` int(10) unsigned NOT NULL,
  `author_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `published_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comments` longtext COLLATE utf8_unicode_ci NOT NULL,
  `image_url` text COLLATE utf8_unicode_ci NOT NULL,
  `is_google_play` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table app_market_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_market_versions`;

CREATE TABLE `app_market_versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `app_market_id` int(10) unsigned NOT NULL DEFAULT '0',
  `app_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `signature` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sha_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` double(255,2) NOT NULL,
  `original_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_link` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_market_versions_user_id_foreign` (`user_id`),
  KEY `app_market_versions_app_market_id_foreign` (`app_market_id`),
  KEY `app_market_versions_app_version_index` (`app_version`),
  CONSTRAINT `app_market_versions_app_market_id_foreign` FOREIGN KEY (`app_market_id`) REFERENCES `app_markets` (`id`),
  CONSTRAINT `app_market_versions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table app_markets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_markets`;

CREATE TABLE `app_markets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `app_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` text COLLATE utf8_unicode_ci NOT NULL,
  `ratings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ratings_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `developer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `developer_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `required_android` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `installs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom` longtext COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_descriptions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `is_featured` int(11) NOT NULL DEFAULT '0',
  `is_submitted_app` int(11) NOT NULL DEFAULT '0',
  `is_demo` int(11) NOT NULL DEFAULT '0',
  `published_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_markets_user_id_foreign` (`user_id`),
  CONSTRAINT `app_markets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table categoreables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categoreables`;

CREATE TABLE `categoreables` (
  `category_id` int(11) NOT NULL,
  `categoreable_id` int(11) NOT NULL,
  `categoreable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_category_id` int(10) unsigned NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_descriptions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `is_featured` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `is_demo` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_parent_category_id_index` (`parent_category_id`),
  KEY `categories_identifier_index` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `parent_category_id`, `identifier`, `title`, `description`, `seo_title`, `seo_keywords`, `seo_descriptions`, `is_enabled`, `is_featured`, `icon`, `views`, `is_demo`, `created_at`, `updated_at`)
VALUES
	(1,1,'business','Business','Business','Business','business','Business',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(2,1,'comics','Comics','Comics','Comics','comics','Comics',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(3,1,'communication','Communication','Communication','Communication','communication','Communication',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(4,1,'dating','Dating','Dating','Dating','dating','Dating',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(5,1,'education','Education','Education','Education','education','Education',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(6,1,'entertainment','Entertainment','Entertainment','Entertainment','entertainment','Entertainment',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(7,1,'events','Events','Events','Events','events','Events',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(8,1,'finance','Finance','Finance','Finance','finance','Finance',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(9,1,'food-drink','Food & Drink','Food & Drink','Food & Drink','food-drink','Food & Drink',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(10,1,'health-fitness','Health & Fitness','Health & Fitness','Health & Fitness','health-fitness','Health & Fitness',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(11,1,'house-home','House & Home','House & Home','House & Home','house-home','House & Home',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(12,1,'libraries-demo','Libraries & Demo','Libraries & Demo','Libraries & Demo','libraries-demo','Libraries & Demo',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(13,1,'lifestyle','Lifestyle','Lifestyle','Lifestyle','lifestyle','Lifestyle',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(14,1,'maps-navigation','Maps & Navigation','Maps & Navigation','Maps & Navigation','maps-navigation','Maps & Navigation',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(15,1,'medical','Medical','Medical','Medical','medical','Medical',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(16,1,'music-audio','Music & Audio','Music & Audio','Music & Audio','music-audio','Music & Audio',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(17,1,'news-magazines','News & Magazines','News & Magazines','News & Magazines','news-magazines','News & Magazines',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(18,1,'parenting','Parenting','Parenting','Parenting','parenting','Parenting',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(19,1,'personalization','Personalization','Personalization','Personalization','personalization','Personalization',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(20,1,'photography','Photography','Photography','Photography','photography','Photography',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(21,1,'productivity','Productivity','Productivity','Productivity','productivity','Productivity',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(22,1,'shopping','Shopping','Shopping','Shopping','shopping','Shopping',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(23,1,'social','Social','Social','Social','social','Social',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(24,2,'sports','Sports','Sports','Sports','sports','Sports',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(25,1,'tools','Tools','Tools','Tools','tools','Tools',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(26,1,'travel-local','Travel & Local','Travel & Local','Travel & Local','travel-local','Travel & Local',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(27,1,'video-players-editors','Video Players & Editors','Video Players & Editors','Video Players & Editors','video-players-editors','Video Players & Editors',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(28,1,'weather','Weather','Weather','Weather','weather','Weather',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(29,2,'action','Action','Action','Action','action','Action',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(30,2,'adventure','Adventure','Adventure','Adventure','adventure','Adventure',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(31,2,'arcade','Arcade','Arcade','Arcade','arcade','Arcade',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(32,2,'board','Board','Board','Board','board','Board',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(33,2,'card','Card','Card','Card','card','Card',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(34,2,'casino','Casino','Casino','Casino','casino','Casino',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(35,2,'casual','Casual','Casual','Casual','casual','Casual',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(36,2,'educational','Educational','Educational','Educational','educational','Educational',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(37,2,'music','Music','Music','Music','music','Music',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(38,2,'puzzle','Puzzle','Puzzle','Puzzle','puzzle','Puzzle',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(39,2,'racing','Racing','Racing','Racing','racing','Racing',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(40,2,'role-playing','Role Playing','Role Playing','Role Playing','role-playing','Role Playing',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(41,2,'simulation','Simulation','Simulation','Simulation','simulation','Simulation',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(42,2,'strategy','Strategy','Strategy','Strategy','strategy','Strategy',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(43,2,'trivia','Trivia','Trivia','Trivia','trivia','Trivia',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(44,2,'word','Word','Word','Word','word','Word',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(45,2,'family','Family','Family','Family','family','Family',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(46,3,'live-wallpaper','Live Wallpaper','Live Wallpaper','Live Wallpaper','live-wallpaper','Live Wallpaper',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(47,3,'go-theme','Go Theme','Go Theme','Go Theme','go-theme','Go Theme',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(48,3,'360-theme','360 Theme','360 Theme','360 Theme','360-theme','360 Theme',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(49,3,'mi-theme','MI Theme','MI Theme','MI Theme','mi-theme','MI Theme',1,0,'',0,0,'2017-09-08 16:25:56','2017-09-08 16:25:56');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table configurations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `configurations`;

CREATE TABLE `configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `configurations_key_index` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `configurations` WRITE;
/*!40000 ALTER TABLE `configurations` DISABLE KEYS */;

INSERT INTO `configurations` (`id`, `group_slug`, `key`, `value`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'general_informations','cms_name','Your Site Name Here','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(2,'general_informations','cms_description','Your site descriptions','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(3,'general_informations','set_your_locale','en','Ex. \"en\" for english language','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(4,'general_informations','your_country_code','us','Ex. \"us\" for United States','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(5,'general_informations','contact_email','youremailhere@mailnator.com','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(6,'general_informations','enable_submit_apps','1','1 = Enable Submit Apps from users, 0 = Disable submit apps','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(7,'general_informations','enable_https','0','1 = Enable HTTPS, 0 = Disable HTTPS','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(8,'general_informations','disqus_short_name','your_disqus_short_code_here','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(9,'general_informations','addthis_code','your_add_this_code_here','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(10,'seo_configurations','site_title','Your Site Name Here','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(11,'seo_configurations','site_description','Your Site Name Here','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(12,'seo_configurations','site_keywords','your,keyword,goes,here','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(13,'seo_configurations','site_author','Author of the site','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(14,'seo_configurations','site_author_link','http://yourwebsitehere.com','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(15,'social_networks','facebook','#','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(16,'social_networks','twitter','#','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(17,'social_networks','instagram','#','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(18,'social_networks','pinterest','#','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(19,'social_networks','google','#','','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(20,'google_webmaster_tools','site_analytics','','Paste your tracker code here. Ex. UA-XXXXX-Y','2017-09-08 16:25:56','2017-10-18 02:22:37'),
	(21,'google_webmaster_tools','site_verification','','Paste your verification code here.','2017-09-08 16:25:56','2017-10-18 02:22:37'),
	(22,'general_informations','cms_upload_logo','','','2017-10-18 02:22:26','2017-10-18 02:22:26'),
	(23,'general_informations','enable_rtl_support','no','Ex. \"yes\" to enable, no = disable','2017-10-18 02:22:26','2017-10-18 02:22:26'),
	(24,'general_informations','auto_activate_user_registration','yes','Ex. \"yes\" to auto activate, no = it will send email for activation before login.','2017-10-18 02:22:37','2017-10-18 02:22:37'),
	(25,'custom_css_and_js','custom_css','','Paste your custom css here','2017-10-18 02:22:37','2017-10-18 02:22:37'),
	(26,'custom_css_and_js','custom_js','','Paste your custom js here','2017-10-18 02:22:37','2017-10-18 02:22:37'),
	(27,'recaptcha_api_key','recaptcha_site_key','','Paste your site key here.','2017-10-18 02:22:37','2017-10-18 02:22:37'),
	(28,'recaptcha_api_key','recaptcha_secret_key','','Paste your secret key here.','2017-10-18 02:22:37','2017-10-18 02:22:37'),
	(29,'recaptcha_api_key','enable_recaptcha','no','Ex. \"no\" to deactivate, \"yes\" = to enabled,please visit get your key: https://www.google.com/recaptcha/intro/android.html','2017-10-18 02:22:37','2017-10-18 02:22:37'),
  (30,'apk_download_via_api','purchase_code','','Paste your purchase code here.','2017-10-18 02:22:37','2017-10-18 02:22:37'),
  (31,'apk_download_via_api','buyer_username','','Paste your username here to verify.','2017-10-18 02:22:37','2017-10-18 02:22:37'),
	(32,'general_informations','app_version','1.3','App version.','2017-10-18 02:22:37','2017-10-18 02:22:37');

/*!40000 ALTER TABLE `configurations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ltm_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ltm_translations`;

CREATE TABLE `ltm_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `ltm_translations` WRITE;
/*!40000 ALTER TABLE `ltm_translations` DISABLE KEYS */;

INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`)
VALUES
	(1,1,'en','auth','failed','These credentials do not match our records.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(2,1,'en','auth','throttle','Too many login attempts. Please try again in :seconds seconds.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(3,1,'en','auth','user_not_found','User was not found.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(4,1,'en','auth','user_not_activated','User is not activated.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(5,1,'en','auth','user_is_suspended','User is suspended.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(6,1,'en','auth','user_is_banned','User is banned.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(7,1,'en','auth','user_access_denied','Access denied.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(8,1,'en','frontend','common.home','Home','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(9,1,'en','frontend','common.name','Name','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(10,1,'en','frontend','common.name_placeholder','Input your name','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(11,1,'en','frontend','common.email_add','Email Address','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(12,1,'en','frontend','common.email_add_placeholder','Input your email address','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(13,1,'en','frontend','common.message','Message','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(14,1,'en','frontend','common.submit_apps','Submit My App','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(15,1,'en','frontend','common.copyright','<span>Copyright</span>','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(16,1,'en','frontend','common.see_more','See more...','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(17,1,'en','frontend','common.search_result','Search Result For <strong>(:item)</strong>','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(18,1,'en','frontend','common.download_title','Download apk file for ','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(19,1,'en','frontend','common.playstore_link','Google Play Store Link','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(20,1,'en','frontend','common.report_app','Flag as inappropriate','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(21,1,'en','frontend','common.no_result_found','No Result Found!','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(22,1,'en','frontend','common.categories','Categories','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(23,1,'en','frontend','common.no_category','No Category Setup.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(24,1,'en','frontend','common.comments','Comments','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(25,1,'en','frontend','common.description','Description','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(26,1,'en','frontend','common.most_popular','Most Popular Apps/Games','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(27,1,'en','frontend','common.user_review','User Reviews','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(28,1,'en','frontend','common.no_review','No available reviews for this app.','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(29,1,'en','frontend','common.screenshot','Screenshots','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(30,1,'en','frontend','common.download','Download','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(31,1,'en','frontend','common.version','Version','2017-10-18 02:33:46','2017-10-18 02:33:46'),
	(32,1,'en','frontend','common.signature','Signature','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(33,1,'en','frontend','common.apk_sha1','APK File SHA1','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(34,1,'en','frontend','common.no_download_apk','No available apk for downloads.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(35,1,'en','frontend','common.most_popular_cat','Most Popular Categories','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(36,1,'en','frontend','common.most_popular_apps','Most Popular Apps','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(37,1,'en','frontend','common.translate','Translate','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(38,1,'en','frontend','index.setup_in_admin','Setup using admin page.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(39,1,'en','frontend','index.no_apps','No Apps/Games Added, Please setup new apps in the admin page.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(40,1,'en','frontend','index.newly_added','Newly Added Apps/Games','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(41,1,'en','frontend','index.newly_submit','Newly Submitted Apps/Games by Developers','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(42,1,'en','frontend','index.editors_pick','Editors\' Picks','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(43,1,'en','frontend','index.editors_pick_meta_description','Editors\' Picks - Top Android Apps/Game for this month','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(44,1,'en','frontend','index.rss_feeds','RSS Feeds','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(45,1,'en','frontend','index.sitemap','Sitemap','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(46,1,'en','frontend','index.newest_app','Newly Added Apps','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(47,1,'en','frontend','header.admin','Admin','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(48,1,'en','frontend','header.submit_apps','My Submitted Apps','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(49,1,'en','frontend','header.my_profile','My Profile','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(50,1,'en','frontend','header.logout','Logout','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(51,1,'en','frontend','header.login_register','Login / Register','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(52,1,'en','frontend','app_detail.views','Views','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(53,1,'en','frontend','app_detail.by','By','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(54,1,'en','frontend','app_detail.automatic_download','Automatic Download file after','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(55,1,'en','frontend','app_detail.seconds','sec(s)','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(56,1,'en','frontend','app_detail.remaining_time','Remaining Time','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(57,1,'en','frontend','app_detail.ratings','Ratings','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(58,1,'en','frontend','app_detail.additional_info','Additional informations','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(59,1,'en','frontend','app_detail.required_android','Required Android','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(60,1,'en','frontend','app_detail.installs','Installs','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(61,1,'en','frontend','app_detail.download_apk','Download Apk','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(62,1,'en','frontend','app_detail.apk_version_history','APK Version History','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(63,1,'en','frontend','app_detail.read_more_reviews','Read more reviews..','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(64,1,'en','frontend','app_detail.updated_at','Published/Updated Date','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(65,1,'en','frontend','app_detail.total','Total','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(66,1,'en','frontend','app_detail.rated_link','Rated <strong>:attr</strong> stars out of five star ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(67,1,'en','frontend','app_detail.related_apps','Related Apps','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(68,1,'en','frontend','contact_us.title','Contact Us','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(69,1,'en','frontend','contact_us.name','Name','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(70,1,'en','frontend','contact_us.email','Email Address','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(71,1,'en','frontend','contact_us.message','Messages','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(72,1,'en','frontend','contact_us.submit','Submit','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(73,1,'en','frontend','report_title','Report Content Spam or Abuse','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(74,1,'en','frontend','report_btn','Send Report','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(75,1,'en','frontend','report_heading','Reason why you want to report this content or app','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(76,1,'en','frontend','report_message','Questions or Comments about this app','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(77,1,'en','frontend','report_content_name','Content Name','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(78,1,'en','frontend','report_content_url','Content Url','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(79,1,'en','frontend','report_reasons.0','Graphic violence','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(80,1,'en','frontend','report_reasons.1','Hateful or abusive content','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(81,1,'en','frontend','report_reasons.2','Improper content rating','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(82,1,'en','frontend','report_reasons.3','Virus or other malware issues','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(83,1,'en','frontend','report_reasons.4','Violate Terms and Conditions','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(84,1,'en','frontend','report_reasons.5','Others','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(85,1,'en','frontend','report_mail.success_message','Successfully send your report, Please wait for our response.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(86,1,'en','frontend','report_mail.thankyou','Thank you','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(87,1,'en','frontend','submit_apps.title','Submit Your Android Apps / Games','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(88,1,'en','frontend','submit_apps.app_detail','App Details','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(89,1,'en','frontend','submit_apps.app_detail_desc','Show all information about your app/game','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(90,1,'en','frontend','submit_apps.google_play_id','Google Playstore App ID','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(91,1,'en','frontend','submit_apps.instruction_message','<em>Ex. Use the app id from google playstore url detail page like this -> <strong class=\"text-success\">https://play.google.com/store/apps/details?id=com.twitter.android</strong>just get the app id: <strong class=\"text-success\">com.twitter.android</strong> or Just input your app id.</em>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(92,1,'en','frontend','submit_apps.unique_app','Note* must be unique app id.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(93,1,'en','frontend','submit_apps.enter_app_placeholder','Enter app id manually','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(94,1,'en','frontend','submit_apps.get_details','Get Details','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(95,1,'en','frontend','submit_apps.get_details_desc','If you submitted already your app to google play and want to submit here,used this options to get the details automatic.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(96,1,'en','frontend','submit_apps.remove_image',' Remove Image','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(97,1,'en','frontend','submit_apps.upload_main_app_image','Upload Main App Image','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(98,1,'en','frontend','submit_apps.note_manual_image_upload','Note: * If you upload manual image, thats the first one we will used in our frontend before the image link from google play.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(99,1,'en','frontend','submit_apps.image_upload_url','Image Uploaded Url','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(100,1,'en','frontend','submit_apps.image_link_from_google_play','Image Link from Google Play','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(101,1,'en','frontend','submit_apps.app_name','App Name','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(102,1,'en','frontend','submit_apps.google_play_link','Google Play Link','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(103,1,'en','frontend','submit_apps.select_categories','Select App Categories','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(104,1,'en','frontend','submit_apps.description','Description','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(105,1,'en','frontend','submit_apps.developer_detail','Developer Details | <small> Informations about the developers</small>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(106,1,'en','frontend','submit_apps.developer_name',' Developer Name','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(107,1,'en','frontend','submit_apps.developer_link','Developer Link Url','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(108,1,'en','frontend','submit_apps.app_screenshots','App Screenshots | <small> Upload app screenshots</small>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(109,1,'en','frontend','submit_apps.screenshot_desc','Add Screenshots','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(110,1,'en','frontend','submit_apps.drag_drop','DRAG N\' DROP','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(111,1,'en','frontend','submit_apps.upload_browse','Browse','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(112,1,'en','frontend','submit_apps.change','Change','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(113,1,'en','frontend','submit_apps.add_new_apps','Add New Apps','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(114,1,'en','frontend','submit_apps.delete_app','Delete App','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(115,1,'en','frontend','submit_apps.update_info','Update Information','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(116,1,'en','pagination','previous','&laquo; Previous','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(117,1,'en','pagination','next','Next &raquo;','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(118,1,'en','passwords','password','Passwords must be at least six characters and match the confirmation.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(119,1,'en','passwords','reset','Your password has been reset!','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(120,1,'en','passwords','sent','We have e-mailed your password reset link!','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(121,1,'en','passwords','token','This password reset token is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(122,1,'en','passwords','user','We can\'t find a user with that e-mail address.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(123,1,'en','validation','accepted','The :attribute must be accepted.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(124,1,'en','validation','active_url','The :attribute is not a valid URL.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(125,1,'en','validation','after','The :attribute must be a date after :date.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(126,1,'en','validation','alpha','The :attribute may only contain letters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(127,1,'en','validation','alpha_dash','The :attribute may only contain letters, numbers, and dashes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(128,1,'en','validation','alpha_num','The :attribute may only contain letters and numbers.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(129,1,'en','validation','array','The :attribute must be an array.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(130,1,'en','validation','before','The :attribute must be a date before :date.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(131,1,'en','validation','between.numeric','The :attribute must be between :min and :max.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(132,1,'en','validation','between.file','The :attribute must be between :min and :max kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(133,1,'en','validation','between.string','The :attribute must be between :min and :max characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(134,1,'en','validation','between.array','The :attribute must have between :min and :max items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(135,1,'en','validation','boolean','The :attribute field must be true or false.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(136,1,'en','validation','confirmed','The :attribute confirmation does not match.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(137,1,'en','validation','date','The :attribute is not a valid date.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(138,1,'en','validation','date_format','The :attribute does not match the format :format.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(139,1,'en','validation','different','The :attribute and :other must be different.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(140,1,'en','validation','digits','The :attribute must be :digits digits.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(141,1,'en','validation','digits_between','The :attribute must be between :min and :max digits.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(142,1,'en','validation','distinct','The :attribute field has a duplicate value.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(143,1,'en','validation','email','The :attribute must be a valid email address.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(144,1,'en','validation','exists','The selected :attribute is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(145,1,'en','validation','filled','The :attribute field is required.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(146,1,'en','validation','image','The :attribute must be an image.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(147,1,'en','validation','in','The selected :attribute is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(148,1,'en','validation','in_array','The :attribute field does not exist in :other.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(149,1,'en','validation','integer','The :attribute must be an integer.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(150,1,'en','validation','ip','The :attribute must be a valid IP address.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(151,1,'en','validation','json','The :attribute must be a valid JSON string.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(152,1,'en','validation','max.numeric','The :attribute may not be greater than :max.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(153,1,'en','validation','max.file','The :attribute may not be greater than :max kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(154,1,'en','validation','max.string','The :attribute may not be greater than :max characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(155,1,'en','validation','max.array','The :attribute may not have more than :max items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(156,1,'en','validation','mimes','The :attribute must be a file of type: :values.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(157,1,'en','validation','min.numeric','The :attribute must be at least :min.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(158,1,'en','validation','min.file','The :attribute must be at least :min kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(159,1,'en','validation','min.string','The :attribute must be at least :min characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(160,1,'en','validation','min.array','The :attribute must have at least :min items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(161,1,'en','validation','not_in','The selected :attribute is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(162,1,'en','validation','numeric','The :attribute must be a number.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(163,1,'en','validation','present','The :attribute field must be present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(164,1,'en','validation','regex','The :attribute format is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(165,1,'en','validation','required','The :attribute field is required.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(166,1,'en','validation','required_if','The :attribute field is required when :other is :value.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(167,1,'en','validation','required_unless','The :attribute field is required unless :other is in :values.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(168,1,'en','validation','required_with','The :attribute field is required when :values is present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(169,1,'en','validation','required_with_all','The :attribute field is required when :values is present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(170,1,'en','validation','required_without','The :attribute field is required when :values is not present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(171,1,'en','validation','required_without_all','The :attribute field is required when none of :values are present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(172,1,'en','validation','same','The :attribute and :other must match.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(173,1,'en','validation','size.numeric','The :attribute must be :size.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(174,1,'en','validation','size.file','The :attribute must be :size kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(175,1,'en','validation','size.string','The :attribute must be :size characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(176,1,'en','validation','size.array','The :attribute must contain :size items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(177,1,'en','validation','string','The :attribute must be a string.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(178,1,'en','validation','timezone','The :attribute must be a valid zone.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(179,1,'en','validation','unique','The :attribute has already been taken.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(180,1,'en','validation','url','The :attribute format is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(181,1,'en','validation','recaptcha','Please ensure that you are a human!','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(182,1,'en','validation','custom.attribute-name.rule-name','custom-message','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(183,1,'jp','auth','failed','These credentials do not match our records.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(184,1,'jp','auth','throttle','Too many login attempts. Please try again in :seconds seconds.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(185,1,'jp','auth','user_not_found','User was not found.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(186,1,'jp','auth','user_not_activated','User is not activated.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(187,1,'jp','auth','user_is_suspended','User is suspended.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(188,1,'jp','auth','user_is_banned','User is banned.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(189,1,'jp','auth','user_access_denied','Access denied.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(190,1,'jp','frontend','common.home','ホーム','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(191,1,'jp','frontend','common.name','名','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(192,1,'jp','frontend','common.name_placeholder','あなたの名前を入力してください','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(193,1,'jp','frontend','common.email_add','電子メールアドレス','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(194,1,'jp','frontend','common.email_add_placeholder','あなたのメールアドレスを入力してください','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(195,1,'jp','frontend','common.message','メッセージ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(196,1,'jp','frontend','common.submit_apps','私のアプリを提出する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(197,1,'jp','frontend','common.copyright','<span>著作権</span>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(198,1,'jp','frontend','common.see_more','続きを見る...','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(199,1,'jp','frontend','common.search_result','検索結果 <strong>(:item)</strong>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(200,1,'jp','frontend','common.download_title','のためのAPKファイルをダウンロード ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(201,1,'jp','frontend','common.playstore_link','Google Playストアリンク','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(202,1,'jp','frontend','common.report_app','不適切とフラグを設定する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(203,1,'jp','frontend','common.no_result_found','結果が見つかりません！','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(204,1,'jp','frontend','common.categories','カテゴリー','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(205,1,'jp','frontend','common.no_category','カテゴリ設定がありません。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(206,1,'jp','frontend','common.comments','コメント','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(207,1,'jp','frontend','common.description','説明','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(208,1,'jp','frontend','common.most_popular','人気アプリ/ゲーム','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(209,1,'jp','frontend','common.user_review','ユーザーレビュー','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(210,1,'jp','frontend','common.no_review','このアプリのレビューはありません。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(211,1,'jp','frontend','common.screenshot','スクリーンショット','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(212,1,'jp','frontend','common.download','ダウンロード','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(213,1,'jp','frontend','common.version','バージョン','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(214,1,'jp','frontend','common.signature','署名','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(215,1,'jp','frontend','common.apk_sha1','APKファイルSHA1','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(216,1,'jp','frontend','common.no_download_apk','ダウンロードに利用できるapkはありません。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(217,1,'jp','frontend','common.most_popular_cat','最も人気のあるカテゴリ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(218,1,'jp','frontend','common.most_popular_apps','人気アプリ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(219,1,'jp','frontend','common.translate','翻訳','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(220,1,'jp','frontend','index.setup_in_admin','管理ページを使用して設定します。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(221,1,'jp','frontend','index.no_apps','アプリ/ゲームが追加されていません。管理ページで新しいアプリを設定してください。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(222,1,'jp','frontend','index.newly_added','新しく追加されたアプリ/ゲーム','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(223,1,'jp','frontend','index.newly_submit','新しく提出されたアプリ/開発者によるゲーム','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(224,1,'jp','frontend','index.editors_pick','編集者のおすすめ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(225,1,'jp','frontend','index.editors_pick_meta_description','Editors \' Picks  - 今月のAndroidアプリ/ゲームランキング','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(226,1,'jp','frontend','index.rss_feeds','RSSフィード','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(227,1,'jp','frontend','index.sitemap','サイトマップ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(228,1,'jp','frontend','index.newest_app','新しく追加されたアプリ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(229,1,'jp','frontend','header.admin','管理者','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(230,1,'jp','frontend','header.submit_apps','私の提出されたアプリ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(231,1,'jp','frontend','header.my_profile','私のプロフィール','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(232,1,'jp','frontend','header.logout','ログアウト','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(233,1,'jp','frontend','header.login_register','ログイン/登録','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(234,1,'jp','frontend','app_detail.views','ビュー','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(235,1,'jp','frontend','app_detail.by','〜によって','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(236,1,'jp','frontend','app_detail.automatic_download','自動ダウンロード後のファイル','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(237,1,'jp','frontend','app_detail.seconds','秒（秒）','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(238,1,'jp','frontend','app_detail.remaining_time','残り時間','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(239,1,'jp','frontend','app_detail.ratings','評価','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(240,1,'jp','frontend','app_detail.additional_info','追加情報','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(241,1,'jp','frontend','app_detail.required_android','必要なAndroid','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(242,1,'jp','frontend','app_detail.installs','インストール','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(243,1,'jp','frontend','app_detail.download_apk','Apkをダウンロード','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(244,1,'jp','frontend','app_detail.apk_version_history','APKのバージョン履歴','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(245,1,'jp','frontend','app_detail.read_more_reviews','もっとレビューを読む..','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(246,1,'jp','frontend','app_detail.updated_at','公開日/更新日','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(247,1,'jp','frontend','app_detail.total','合計','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(248,1,'jp','frontend','app_detail.rated_link','定格 <strong>:attr</strong> 5つ星の星 ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(249,1,'jp','frontend','app_detail.related_apps','関連アプリ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(250,1,'jp','frontend','contact_us.title','お問い合わせ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(251,1,'jp','frontend','contact_us.name','名','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(252,1,'jp','frontend','contact_us.email','電子メールアドレス','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(253,1,'jp','frontend','contact_us.message','メッセージ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(254,1,'jp','frontend','contact_us.submit','提出する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(255,1,'jp','frontend','report_title','レポートの内容スパムまたは嫌がらせ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(256,1,'jp','frontend','report_btn','レポートを送信する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(257,1,'jp','frontend','report_heading','このコンテンツやアプリを報告する理由','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(258,1,'jp','frontend','report_message','このアプリに関する質問やコメント','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(259,1,'jp','frontend','report_content_name','コンテンツ名','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(260,1,'jp','frontend','report_content_url','コンテンツURL','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(261,1,'jp','frontend','report_reasons.0','グラフィック暴力','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(262,1,'jp','frontend','report_reasons.1','嫌悪または虐待的なコンテンツ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(263,1,'jp','frontend','report_reasons.2','不適切なコンテンツの評価','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(264,1,'jp','frontend','report_reasons.3','ウイルスやその他のマルウェアの問題','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(265,1,'jp','frontend','report_reasons.4','利用規約に違反する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(266,1,'jp','frontend','report_reasons.5','その他','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(267,1,'jp','frontend','report_mail.success_message','レポートを正常に送信しました。私たちの応答をお待ちください。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(268,1,'jp','frontend','report_mail.thankyou','ありがとうございました','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(269,1,'jp','frontend','submit_apps.title','あなたのAndroidアプリ/ゲームを提出する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(270,1,'jp','frontend','submit_apps.app_detail','アプリの詳細','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(271,1,'jp','frontend','submit_apps.app_detail_desc','あなたのアプリ/ゲームに関するすべての情報を表示する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(272,1,'jp','frontend','submit_apps.google_play_id','Google PlayストアのアプリID','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(273,1,'jp','frontend','submit_apps.instruction_message','<em>Ex。このようなgoogle playstore urlの詳細ページのアプリIDを使用する -> <strong class=\"text-success\">https://play.google.com/store/apps/details?id=com.twitter.android</strong> ちょうどアプリIDを取得する: <strong class=\"text-success\">com.twitter.android</strong>またはあなたのアプリIDを入力するだけです.</em>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(274,1,'jp','frontend','submit_apps.unique_app','注*は一意のアプリIDでなければなりません。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(275,1,'jp','frontend','submit_apps.enter_app_placeholder','手動でアプリIDを入力','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(276,1,'jp','frontend','submit_apps.get_details','詳細を取得する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(277,1,'jp','frontend','submit_apps.get_details_desc','すでにGoogle Playにアプリを送信していて、ここに送信したい場合は、このオプションを使用して詳細を自動的に取得します。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(278,1,'jp','frontend','submit_apps.remove_image',' イメージを削除','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(279,1,'jp','frontend','submit_apps.upload_main_app_image','メインアプリイメージをアップロードする','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(280,1,'jp','frontend','submit_apps.note_manual_image_upload','注：*手動イメージをアップロードすると、Googleのフロントエンドで使用される最初のイメージがGoogleのイメージリンクより先に再生されます。','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(281,1,'jp','frontend','submit_apps.image_upload_url','画像アップロードされたURL','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(282,1,'jp','frontend','submit_apps.image_link_from_google_play','Google Playの画像リンク','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(283,1,'jp','frontend','submit_apps.app_name','アプリ名','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(284,1,'jp','frontend','submit_apps.google_play_link','Google Playリンク','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(285,1,'jp','frontend','submit_apps.select_categories','アプリカテゴリを選択','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(286,1,'jp','frontend','submit_apps.description','説明','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(287,1,'jp','frontend','submit_apps.developer_detail','開発者の詳細| <small>開発者に関する情報</ small>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(288,1,'jp','frontend','submit_apps.developer_name',' 開発者名','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(289,1,'jp','frontend','submit_apps.developer_link','デベロッパーリンクのURL','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(290,1,'jp','frontend','submit_apps.app_screenshots','アプリスクリーンショット| <small>アプリのスクリーンショットをアップロードする</ small>','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(291,1,'jp','frontend','submit_apps.screenshot_desc','スクリーンショットを追加','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(292,1,'jp','frontend','submit_apps.drag_drop','DRAG N\' DROP','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(293,1,'jp','frontend','submit_apps.upload_browse','ブラウズ','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(294,1,'jp','frontend','submit_apps.change','変化する','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(295,1,'jp','frontend','submit_apps.add_new_apps','新しいアプリを追加','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(296,1,'jp','frontend','submit_apps.delete_app','アプリを削除','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(297,1,'jp','frontend','submit_apps.update_info','更新情報','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(298,1,'jp','pagination','previous','&laquo; Previous','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(299,1,'jp','pagination','next','Next &raquo;','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(300,1,'jp','passwords','password','Passwords must be at least six characters and match the confirmation.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(301,1,'jp','passwords','reset','Your password has been reset!','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(302,1,'jp','passwords','sent','We have e-mailed your password reset link!','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(303,1,'jp','passwords','token','This password reset token is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(304,1,'jp','passwords','user','We can\'t find a user with that e-mail address.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(305,1,'jp','validation','accepted','The :attribute must be accepted.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(306,1,'jp','validation','active_url','The :attribute is not a valid URL.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(307,1,'jp','validation','after','The :attribute must be a date after :date.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(308,1,'jp','validation','alpha','The :attribute may only contain letters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(309,1,'jp','validation','alpha_dash','The :attribute may only contain letters, numbers, and dashes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(310,1,'jp','validation','alpha_num','The :attribute may only contain letters and numbers.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(311,1,'jp','validation','array','The :attribute must be an array.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(312,1,'jp','validation','before','The :attribute must be a date before :date.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(313,1,'jp','validation','between.numeric','The :attribute must be between :min and :max.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(314,1,'jp','validation','between.file','The :attribute must be between :min and :max kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(315,1,'jp','validation','between.string','The :attribute must be between :min and :max characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(316,1,'jp','validation','between.array','The :attribute must have between :min and :max items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(317,1,'jp','validation','boolean','The :attribute field must be true or false.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(318,1,'jp','validation','confirmed','The :attribute confirmation does not match.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(319,1,'jp','validation','date','The :attribute is not a valid date.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(320,1,'jp','validation','date_format','The :attribute does not match the format :format.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(321,1,'jp','validation','different','The :attribute and :other must be different.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(322,1,'jp','validation','digits','The :attribute must be :digits digits.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(323,1,'jp','validation','digits_between','The :attribute must be between :min and :max digits.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(324,1,'jp','validation','distinct','The :attribute field has a duplicate value.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(325,1,'jp','validation','email','The :attribute must be a valid email address.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(326,1,'jp','validation','exists','The selected :attribute is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(327,1,'jp','validation','filled','The :attribute field is required.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(328,1,'jp','validation','image','The :attribute must be an image.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(329,1,'jp','validation','in','The selected :attribute is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(330,1,'jp','validation','in_array','The :attribute field does not exist in :other.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(331,1,'jp','validation','integer','The :attribute must be an integer.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(332,1,'jp','validation','ip','The :attribute must be a valid IP address.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(333,1,'jp','validation','json','The :attribute must be a valid JSON string.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(334,1,'jp','validation','max.numeric','The :attribute may not be greater than :max.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(335,1,'jp','validation','max.file','The :attribute may not be greater than :max kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(336,1,'jp','validation','max.string','The :attribute may not be greater than :max characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(337,1,'jp','validation','max.array','The :attribute may not have more than :max items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(338,1,'jp','validation','mimes','The :attribute must be a file of type: :values.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(339,1,'jp','validation','min.numeric','The :attribute must be at least :min.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(340,1,'jp','validation','min.file','The :attribute must be at least :min kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(341,1,'jp','validation','min.string','The :attribute must be at least :min characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(342,1,'jp','validation','min.array','The :attribute must have at least :min items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(343,1,'jp','validation','not_in','The selected :attribute is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(344,1,'jp','validation','numeric','The :attribute must be a number.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(345,1,'jp','validation','present','The :attribute field must be present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(346,1,'jp','validation','regex','The :attribute format is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(347,1,'jp','validation','required','The :attribute field is required.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(348,1,'jp','validation','required_if','The :attribute field is required when :other is :value.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(349,1,'jp','validation','required_unless','The :attribute field is required unless :other is in :values.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(350,1,'jp','validation','required_with','The :attribute field is required when :values is present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(351,1,'jp','validation','required_with_all','The :attribute field is required when :values is present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(352,1,'jp','validation','required_without','The :attribute field is required when :values is not present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(353,1,'jp','validation','required_without_all','The :attribute field is required when none of :values are present.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(354,1,'jp','validation','same','The :attribute and :other must match.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(355,1,'jp','validation','size.numeric','The :attribute must be :size.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(356,1,'jp','validation','size.file','The :attribute must be :size kilobytes.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(357,1,'jp','validation','size.string','The :attribute must be :size characters.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(358,1,'jp','validation','size.array','The :attribute must contain :size items.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(359,1,'jp','validation','string','The :attribute must be a string.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(360,1,'jp','validation','timezone','The :attribute must be a valid zone.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(361,1,'jp','validation','unique','The :attribute has already been taken.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(362,1,'jp','validation','url','The :attribute format is invalid.','2017-10-18 02:33:47','2017-10-18 02:33:47'),
	(363,1,'jp','validation','custom.attribute-name.rule-name','custom-message','2017-10-18 02:33:47','2017-10-18 02:33:47');

/*!40000 ALTER TABLE `ltm_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_07_02_230147_migration_cartalyst_sentinel',1),
	('2017_06_16_031426_init',1),
	('2017_09_08_014851_statistics',1),
	('2014_04_02_193005_create_translations_table',2),
	('2017_09_19_070314_onePointOne',2),
	('2017_09_19_070924_create_ratings_table',2),
	('2017_09_19_075330_create_app_market_reviews_table',2),
	('2017_09_24_014632_create_rating_histograms_table',2),
	('2017_10_06_094018_alter_appmarkets_add_columns',2);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `parent_page_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_descriptions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `is_demo` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_slug_index` (`slug`),
  KEY `pages_user_id_foreign` (`user_id`),
  CONSTRAINT `pages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table parent_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `parent_categories`;

CREATE TABLE `parent_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_descriptions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_demo` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_categories_identifier_index` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `parent_categories` WRITE;
/*!40000 ALTER TABLE `parent_categories` DISABLE KEYS */;

INSERT INTO `parent_categories` (`id`, `identifier`, `title`, `description`, `seo_title`, `seo_keywords`, `seo_descriptions`, `is_enabled`, `icon`, `is_demo`, `created_at`, `updated_at`)
VALUES
	(1,'app','App','App','App','app','App',1,'',0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(2,'game','Game','Game','Game','game','Game',1,'',0,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(3,'theme','Theme','Theme','Theme','theme','Theme',1,'',0,'2017-09-08 16:25:56','2017-09-08 16:25:56');

/*!40000 ALTER TABLE `parent_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table persistences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `persistences`;

CREATE TABLE `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `persistences` WRITE;
/*!40000 ALTER TABLE `persistences` DISABLE KEYS */;

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`)
VALUES
	(1,1,'fbVHUQP3Bzcp1eZA3V1YeIZMRrSX4iG9','2017-09-08 16:26:02','2017-09-08 16:26:02'),
	(6,1,'PIyLPXnXTFpN7KPjKIiywHBX2TFbYdEM','2017-10-18 02:33:37','2017-10-18 02:33:37');

/*!40000 ALTER TABLE `persistences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rating_histograms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rating_histograms`;

CREATE TABLE `rating_histograms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_market_id` int(10) unsigned NOT NULL,
  `num` int(11) NOT NULL,
  `bar_length` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bar_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rating_histograms_app_market_id_foreign` (`app_market_id`),
  CONSTRAINT `rating_histograms_app_market_id_foreign` FOREIGN KEY (`app_market_id`) REFERENCES `app_markets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ratings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ratings`;

CREATE TABLE `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `rateable_id` int(10) unsigned NOT NULL,
  `rateable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_rateable_id_rateable_type_index` (`rateable_id`,`rateable_type`),
  KEY `ratings_rateable_id_index` (`rateable_id`),
  KEY `ratings_rateable_type_index` (`rateable_type`),
  KEY `ratings_user_id_index` (`user_id`),
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table reminders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reminders`;

CREATE TABLE `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table role_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_users`;

CREATE TABLE `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `role_users` WRITE;
/*!40000 ALTER TABLE `role_users` DISABLE KEYS */;

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`)
VALUES
	(1,1,'2017-10-18 02:33:31','2017-10-18 02:33:31');

/*!40000 ALTER TABLE `role_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`)
VALUES
	(1,'elite','elite','{\"admin\":true,\"can_login_admin\":true}','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(2,'moderator','moderator','{\"can_login_admin\":true}','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(3,'normal','normal','{\"can_login_admin\":false}','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(4,'developers','developers','{\"can_login_admin\":false,\"is_developer\":true}','2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(5,'guest','guest',NULL,'2017-09-08 16:25:56','2017-09-08 16:25:56');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table statistics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statistics`;

CREATE TABLE `statistics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statisticable_id` int(11) NOT NULL,
  `statisticable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statuses`;

CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `statuses_identifier_index` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;

INSERT INTO `statuses` (`id`, `identifier`, `name`, `type`, `created_at`, `updated_at`)
VALUES
	(1,'pending','Pending',1,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(2,'draft','Draft',1,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(3,'published','Published',1,'2017-09-08 16:25:56','2017-09-08 16:25:56'),
	(4,'inactive','Inactive',1,'2017-09-08 16:25:56','2017-09-08 16:25:56');

/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table taggables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `taggables`;

CREATE TABLE `taggables` (
  `tag_id` int(11) NOT NULL,
  `taggable_id` int(11) NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `is_demo` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tags_identifier_index` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table throttle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `throttle`;

CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `throttle` WRITE;
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`)
VALUES
	(1,NULL,'global',NULL,'2017-10-18 02:33:06','2017-10-18 02:33:06'),
	(2,NULL,'ip','127.0.0.1','2017-10-18 02:33:06','2017-10-18 02:33:06'),
	(3,1,'user',NULL,'2017-10-18 02:33:06','2017-10-18 02:33:06');

/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `uploads`;

CREATE TABLE `uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `uploadable_id` int(11) NOT NULL,
  `uploadable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `file_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` double(255,2) NOT NULL,
  `original_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `social_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `social_id`, `username`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `created_at`, `updated_at`)
VALUES
	(1,'','admin','admin@demo.com','$2y$10$Xy7B0B.BXtN2fhwFySPxnudltJVy6Ib9zJs6s3FPKi4a70wfkypsC','{\"can_login_admin\":true}','2017-10-18 02:33:37','Admin','Account','2017-09-08 16:25:56','2017-10-18 02:33:37');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
