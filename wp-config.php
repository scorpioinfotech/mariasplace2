<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
/*define('DB_NAME', 'azohub_sw33d');*/
define('DB_NAME', 'maria-new');

/** MySQL database username */
/*define('DB_USER', 'azohub_sw33d');*/
define('DB_USER', 'root');

/** MySQL database password */
/*define('DB_PASSWORD', 's<A>WZ,m+D5/`,8@;{W\\');*/
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '@xg*>TKCH_5Fy9F?O*tp@m3ZuG%MZ7Xig7>=Fb3FbDJWE*3^.WmQe%qaK`_xHsQ7');
define('SECURE_AUTH_KEY',  '$FB_Wzl=4d}e7Ux:(EtZ%0>s#DV.;a$<,m9q$bWVhM(BhmCfVQn-#K=fo(g;pV+a');
define('LOGGED_IN_KEY',    'mfUo+rR]g+ -+rF!Z*U*kPE4PU|AqzM+{tV>qt7+EJ#(cF$Q|)eyyay`7im1%|?y');
define('NONCE_KEY',        'Y0Lq-_~U+G,_1+~uxf+?eP%w9g_`265L?QaZ9?4m+;t5EB#a=2&Ge}*cks8l /h2');
define('AUTH_SALT',        'gxyaP])MGpmmzvEwh:,N&J>ULK&e,:I9}Z QpsV+HlFAh]U!;>C@mWgBDy&aq;R+');
define('SECURE_AUTH_SALT', 'ZS+5]7+&KrR$rNyz_PzmCs`M8=/e/Yd9&G9#*eQ+a?HzSR_v9!Zwe/Bf%w-QpF-)');
define('LOGGED_IN_SALT',   '=gzi&d-(R$l8Uz!i;TYU:GW?9VI7-Ncb_s4P0tO7MA/GPdQW4%3jd1 v_wnx}4(4');
define('NONCE_SALT',       'K*#[EnAA|HAcwG(eG1.h*%ieX%XOsq<X.#$Csm-<;L.#g|zzWJD~:v7thtg5N_]P');

/**#@-*/


// Cookie Domain
// This is a mydomain specific setting
// The intent is to allow users a single signon experiance to all mydomain domains
// However, this may interfear with the multi site setup if the users choose to use a different domain
// So the idea is to set the cookie domain only if it is a mydomain.com domain or subdomain
// Otherwise, just take the default behaviour
if(substr_compare($_SERVER['HTTP_HOST'], 'mariasplace.com',
 -strlen('mariasplace.com'), strlen('mariasplace.com')) == 0) {
	// Define Cookie Domain for mydomain Sites
	define('COOKIE_DOMAIN', 'mariasplace.com');
	// Set the Cookie Hash to something constant for mydomain Sites
	// This should allow single signon if they have subscribed to the services
	// This hash must then be used for the cookies themselves
	define('COOKIE_HASH', md5('mariasplace.com auth services'));
	define('AUTH_COOKIE', 'wordpress_'.COOKIE_HASH);
	define('SECURE_AUTH_COOKIE', 'wordpress_sec_'.COOKIE_HASH);
	define('LOGGED_IN_COOKIE','wordpress_logged_in_'.COOKIE_HASH);
	define('TEST_COOKIE', 'wordpress_test_cookie');
}


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
