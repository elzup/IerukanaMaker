<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| My Constants
|--------------------------------------------------------------------------
|
*/

/*
 * BaseSiteInfo
 */
define('SITE_NAME', '言えるかな？');
define('SITE_DESCRIPTION', '言えるかなゲームを作成したりプレイできるサイトです');

define('META_KEYWORDS', '言えるかな,ierukana');

define('PATH_IMG', 'images/');
define('PATH_LIB', 'lib/');
define('PATH_JS', 'js/');
define('PATH_STYLE', 'style/');
define('PATH_GAME', 'g/');
define('PATH_USER', 'u/');
define('PATH_AUTH', 'auth/');
define('PATH_MAKE', 'make/');
define('PATH_MAKE_POST', 'make/post');

define('PATH_AUTH_LOGIN', 'login');
define('PATH_AUTH_END', PATH_AUTH . 'end');
define('PATH_AUTH_LOGOUT', 'logout');

define('PATH_STYLE_CSS_MAIN', PATH_STYLE . 'main.css');
define('PATH_GOOGLE', 'google');
define('PATH_GOOGLE_ANALYTICS', PATH_GOOGLE . '/analyticstracking.php');
define('PATH_BOOTSTRAP_CSS', PATH_LIB . 'bootstrap/css/bootstrap.min.css');
define('PATH_BOOTSTRAP_JS', PATH_LIB . 'bootstrap/js/bootstrap.min.js');


/* online lib url */
define('URL_TWITTER_WIDGETS', 'http://platform.twitter.com/widgets.js');
define('URL_YAHOO_RESET_CSS', 'http://yui.yahooapis.com/3.0.0/build/cssreset/reset-min.css');
define('URL_JQUERY', 'https://code.jquery.com/jquery.js');

/* DB constnats */
define('DB_TN_USERS', 'users');
define('DB_CN_USERS_ID', 'user_id');
define('DB_CN_USERS_TWITTER_USER_ID', 'twitter_user_id');

define('DB_TN_GAMES', 'games');
define('DB_CN_GAMES_ID', 'game_id');
define('DB_CN_GAMES_USER_ID', 'user_id');
define('DB_CN_GAMES_NAME', 'game_name');
define('DB_CN_GAMES_DESCRIPTION', 'game_description');
define('DB_CN_GAMES_WORDS_NUM', 'words_num');
define('DB_CN_GAMES_WORDS_UNIT', 'words_unit');

define('DB_TN_WORDS', 'words');
define('DB_CN_WORDS_ID', 'word_id');
define('DB_CN_WORDS_GAME_ID', 'game_id');
define('DB_CN_WORDS_TEXT', 'word_text');
define('DB_CN_WORDS_POINT_POSITIVE', 'point_positive');
define('DB_CN_WORDS_POINT_NEGATIVE', 'point_negative');


/* End of file constants.php */
/* Location: ./application/config/constants.php */