<?php
/**
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * -------------------------------------------------------------------------
 * THIS SHOULD ONLY BE USED AS A LAST RESORT WHEN THE WEB INSTALLER FAILS
 *
 * If you are installing Joomla! manually i.e. not using the web browser installer
 * then rename this file to configuration.php e.g.
 *
 * UNIX -> mv configuration.php-dist configuration.php
 * Windows -> rename configuration.php-dist configuration.php
 *
 * Now edit this file and configure the parameters for your site and
 * database.
 */
class JConfig {
	/* Site Settings */
	public $offline = '0';
	public $offline_message = 'This site is down for maintenance.<br /> Please check back again soon.';
	public $display_offline_message = '1';
	public $offline_image = '';
	public $sitename = 'Mi portal';				// Name of Joomla site
	public $editor = 'tinymce';
	public $captcha = '0';
	public $list_limit = '20';
	
	public $access = '1';

	/* Database Settings */
	public $dbtype = 'mysqli';					// Normally mysql
	public $host = 'localhost';					// This is normally set to localhost
	public $user = 'pavimpre_jos1';							// DB username
	public $password = 'T(Eyye7uP622*.9';						// DB password
	public $db = 'pavimpre_jos1';							// DB database name
	public $dbprefix = 'jos_';					// Do not change unless you need to!

	/* Server Settings */
	public $secret = 'aOZnyuikLPxyRGkt'; 		// Change this to something more secure
	public $gzip = '0';
	public $error_reporting = 'default';
	public $helpurl = 'http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help{major}{minor}:{keyref}';
	public $ftp_host = '127.0.0.1';
	public $ftp_port = '21';
	public $ftp_user = NULL;
	public $ftp_pass = NULL;
	public $ftp_root = NULL;
	public $ftp_enable = '';
	public $tmp_path = '/home/pavimpre/domains/pavimpresostalavera.es/public_html/joomla/tmp';
	public $log_path = '/home/pavimpre/domains/pavimpresostalavera.es/public_html/joomla/logs';
	public $live_site = ''; 					// Optional, Full url to Joomla install.
	public $force_ssl = 0;						// Force areas of the site to be SSL ONLY.  0 = None, 1 = Administrator, 2 = Both Site and Administrator

	/* Locale Settings */
	public $offset = 'UTC';

	/* Session settings */
	public $lifetime = '15';					// Session time
	public $session_handler = 'database';

	/* Mail Settings */
	public $mailer = 'mail';
	public $mailfrom = 'javierparis39@terra.es';
	public $fromname = 'Mi portal';
	public $sendmail = '/usr/sbin/sendmail';
	public $smtpauth = '0';
	public $smtpuser = '';
	public $smtppass = '';
	public $smtphost = 'localhost';

	/* Cache Settings */
	public $caching = '0';
	public $cachetime = '15';
	public $cache_handler = 'file';

	/* Debug Settings */
	public $debug = '0';
	public $debug_lang = '0';

	/* Meta Settings */
	public $MetaDesc = 'Joomla! - the dynamic portal engine and content management system';
	public $MetaKeys = 'joomla, Joomla';
	public $MetaTitle = '1';
	public $MetaAuthor = '1';
	public $MetaVersion = '0';
	public $robots = '';

	/* SEO Settings */
	public $sef = '1';
	public $sef_rewrite = '1';
	public $sef_suffix = '0';
	public $unicodeslugs = '0';

	/* Feed Settings */
	public $feed_limit = 10;
	public $feed_email = 'author';
}
