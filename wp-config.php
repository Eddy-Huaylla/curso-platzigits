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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'cursodesarrolloweb' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         ')}</|J7Jw!pKgki&N4,s.~&F,<h%9 CC3-N+w*!}y1.A$R1@!.w6N3V|_*6=bFAw' );
define( 'SECURE_AUTH_KEY',  'u?x2Yq$lMV!gSAi}!;b.H?`|usU0Hm:X/PzK;<uW:w;(mfiv8en?Fm+K}~kLxU:S' );
define( 'LOGGED_IN_KEY',    '!biSOw~,hdupp?m{(qx(!k2#AG^4j{;W <&1?x#`+:R5.OB@K!2 4d)p-,:~QXsr' );
define( 'NONCE_KEY',        '-=+{tD&J_/6k/?@*:g?_.r:vHM,_yR94dj3dCzt?K!~ZVVWt4bc%c+k@3mcUcL:c' );
define( 'AUTH_SALT',        'uL|iYo#HF`2Cx1Z]jC>!x8j^DBE7,unRj**bgLI{0Kr%~{FQevwkla>c2yB2kLbt' );
define( 'SECURE_AUTH_SALT', 'J@g2/L&wTIkiQ`0n:+(eKJx M:jN3EW^F(P@|A.xNYYv*@tVDza8Q]=Bsaheq-wq' );
define( 'LOGGED_IN_SALT',   ')q]Kushq%|T_U/d_vQ`ms4;KD&TXI,n~Oe%qpO?e=ac-qtFUoDhhzuv[lG^Pz*4*' );
define( 'NONCE_SALT',       'LH,?/`MXhD)xs8%%~o2s$.,K1?` 9o)z7#MY8~xEa1D?He%_Na>kLVLPfyNA;lpY' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
