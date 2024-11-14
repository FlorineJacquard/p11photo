<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );
/** Database username */
define( 'DB_USER', 'root' );
/** Database password */
define( 'DB_PASSWORD', 'root' );
/** Database hostname */
define( 'DB_HOST', 'localhost' );
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'yK8c72TUu.7EkMo2zO_VVadI>sj}ZN0#xGdRH=?ZKES}#tfE9T8({6@T[MB5c]8i' );
define( 'SECURE_AUTH_KEY',   ':D7yzf>C?{ivo3_LUS)a=J|^-6i[_S:aB$M0<*`>1q._3ii1:h*,OJ/hsy4.Z}&M' );
define( 'LOGGED_IN_KEY',     '=:$>N{nyPjzvYw,.9l5@yPm8+b7qFj_PrD?|5jW1!Y_gSAE:`?jdNb7ULTOUX)A?' );
define( 'NONCE_KEY',         'j>U~:5FDWS,$78L]J9Q<9/E/<pFs)~H$.~UJ;MRrZGIi/D97<!eHU4KIOir+A>}~' );
define( 'AUTH_SALT',         '&|Z0?*5@rUDsNj:}HS85Mw!q(y>11(</aw&g9 cM*G$q90%~6bVTrIqo/MJuwYz>' );
define( 'SECURE_AUTH_SALT',  'Rdj&=LH&kjf~4`^&*]54AGVRV;Gd/est<{Yk?NT3}ac`OyXlEt/iCE;|9}3,(RZ6' );
define( 'LOGGED_IN_SALT',    'a5<?9T>R@.]QoGDw;p^-}[No6wp3GUEW5h(`:ig3rh6dR<02;,G41pyO45};]Cdm' );
define( 'NONCE_SALT',        '*o{?KO@fant.*xu6YgHNB8Tk@0s}[E8p@Och9Fg7UjX9gqQM3R[zpzlmF|_9{GD[' );
define( 'WP_CACHE_KEY_SALT', 'O1[C-T(eHx/q~RS2ie^8|[nucJ,^88WY8xR|jroOh-0jx5(,D7^AZ[yDXhrATLVb' );
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
/* Add any custom values between this line and the "stop editing" line. */
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';