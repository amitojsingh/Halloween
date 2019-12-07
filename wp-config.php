<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/Z+f8U8W,ruGbf;Z5gftX;M^IO6jot8?l]d0s|ZU.Q:[clC**9c5+(Rr!vkSb%2r' );
define( 'SECURE_AUTH_KEY',  'u%:yut=Y]$c~D8KtI{~V5%~(M|Er)He>hS,^5}Q&(!)nw`,H0&n*X<5/Pz.]}:N~' );
define( 'LOGGED_IN_KEY',    'nnE5Fs!ZiG@7b/T$52P]E9x0Rz9%VmdN@Yq+XyuKyOk@>Kb0?^rmZ9P4,w:rfm::' );
define( 'NONCE_KEY',        '4k(3p2[k#6`z3BY4GUjbTqJ^j.5m&qC!f:Aj<h(y]W.CX+C3WcvE^y4xsE0`r)uG' );
define( 'AUTH_SALT',        '@39h7JziaX475#7UIhzP$5.yE;H?=~YlT6q{t=b0J~SLI1:>.T3c`hppEV:5gZo<' );
define( 'SECURE_AUTH_SALT', '*BhWA3xveg-%WV~ZyXJ;Oh~.`k]^gMyy;<vKr`y}5p1>mPam/v&6RN.][u:wUMP2' );
define( 'LOGGED_IN_SALT',   'D7R<vHvrAKy<M[Czyv Ds+/x][/Vf.- %MlPB&qyB)sa]rC`#1a0@J[+t&{ezBAE' );
define( 'NONCE_SALT',       ']+=([:2A|?AZ,~T0B~S&WO+6C{S7p88#PULl<a<=iDxli$H6<1djOhAO:}x)d=K9' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
