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



define('APP_ROOT', dirname(__DIR__));
define('WP_HOME', 'http://dev.herbertpixner.com');
define('WP_SITEURL', WP_HOME . '/site/');
define('WP_CONTENT_DIR', APP_ROOT . '/content/');
define('WP_CONTENT_URL',  WP_HOME. '/content');
define('WP_CONTENT_URL',  WP_HOME. '/content');
define('WP_PLUGIN_DIR',  APP_ROOT. '/content/plugins');
define('WP_PLUGIN_URL',  WP_HOME. '/content/plugins');
define('PLUGINDIR',  APP_ROOT. '/content/plugins');



/*echo('APP_ROOT ' . APP_ROOT . '<br/>');
echo('WP_HOME ' . WP_HOME . '<br/>');
echo('WP_SITEURL ' . WP_SITEURL . '<br/>');
echo('WP_CONTENT_DIR '.WP_CONTENT_DIR . '<br/>');
echo('WP_CONTENT_URL '.WP_CONTENT_URL . '<br/>');*/



// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dev.herbertpixner.com');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '~;|J~n|WI4),5nf@ep3v|BcG`zVD-u|6iq6az<Oy7igZS3`69%.|v~lD vOa!dQ(');
define('SECURE_AUTH_KEY',  'Umn 935IqI=@#t_I%ms(w>AfYJe-z!`t>yv-^rQ4{K^&-+ky77,c|qb{p`Pt3{Zl');
define('LOGGED_IN_KEY',    '3!ORSu5+fqL>8M?kodG_JUX_S.,f5Tz4>cooQKJ.xPX+_hae`y5(M-ps/+kX3`up');
define('NONCE_KEY',        'HxH)wP0-BQ]6gW6>-lI3aE{]J:|l[m~`isXS91KWiI^6Y:{*DfKph>s!.:sO@3`s');
define('AUTH_SALT',        'v%Nf@+1Gt7!U?Wyy5_6Vwsx}hcmv2!=Yx(Mw$G$Jw3)*qa@_2kVsC^tOuV%i^U05');
define('SECURE_AUTH_SALT', '*tx<g?6]q7|G=s7*+.!&&2tNI=u3$-`q+Y]U+b u?Fc_&~o`$lvRA:osI+!.IbM+');
define('LOGGED_IN_SALT',   's4r?XC3Z]:`qmX7~%_  ~bx`qP(+p|+C(+iFhAEe5xFH $c]w+&.~UNxshwo6!_N');
define('NONCE_SALT',       'dKobUIzuWR^E}Vnn_FoU-,-~X:-pf:!UmVrFhIyin=hT.bN+(,@Eu<bV;pe9?-3f');

/**#@-*/

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
define('WPLANG', 'de_DE');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */


//require_once(dirname(__DIR__) . '/site/wp-settings.php');

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');



