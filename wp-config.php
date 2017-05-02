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
define('DB_NAME', 'mcca_michaelclarkeacademy_com');

/** MySQL database username */
define('DB_USER', 'mymcca1000');

/** MySQL database password */
define('DB_PASSWORD', 'hOc9NZdQ');

/** MySQL hostname */
define('DB_HOST', 'mysql-5.netregistry.net');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('AUTOSAVE_INTERVAL', 3600*24);
define('WP_POST_REVISIONS', false);

/** Increase memory limit */
define('WP_MEMORY_LIMIT', '512M');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Hjs&kMjQb-*iF&C<IJ-z%|1ro5w-.<+jO|15Gk-juS[}&70b=N=]w$_4fw~p}4?w');
define('SECURE_AUTH_KEY',  '[)+/EyB_T9):0=g)h6E-|d$t;QsS#{}b_l=JH]+Fv:;}R9x>iM~D9rY[>hL1>6F;');
define('LOGGED_IN_KEY',    'QR5R_`/-[}B_Xqqnwuw+qvUMr9.3MDm+%cH;1e&}Fs]<|9- Y7`kD=?dM]7/a+s^');
define('NONCE_KEY',        'P`IeRKF<bKq`8ZMGGa-(-B%aOwbto/.O&qj#/*^.+$|FqFzy|=d194]4zT|#a$m1');
define('AUTH_SALT',        'B<?@P+3l7(mu]7hTL6}6&sl>dp VG8i4uL>kOA2W {Eh(_oM(]TfZ2e9+,C~_nCt');
define('SECURE_AUTH_SALT', '95j<+T?4q=JrX],>+vTS(:Fsuvd3,9wjz%(1kT5;3c}NF)#Z[@pU$G}5kke6oQQw');
define('LOGGED_IN_SALT',   'ad4Hm%b6-h+k)wMw,bt Db6,H)`8,ae{$+zJ?{.#7~4yjo9vv/pu%(IAazxbN-9~');
define('NONCE_SALT',       '[H{G:HZ(|aYgEnX3TtRA59ypo42EkNc=>M&6+9GOhHDY6Ltr,^kVp*`X,N5^VMNu');

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
