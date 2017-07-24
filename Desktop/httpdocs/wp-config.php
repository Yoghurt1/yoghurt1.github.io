<?php
define('WP_AUTO_UPDATE_CORE', false);// This setting was defined by WordPress Toolkit to prevent WordPress auto-updates. Do not change it to avoid conflicts with the WordPress Toolkit auto-updates feature.
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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_h' );

/** MySQL database username */
define( 'DB_USER', 'wordpress_m' );

/** MySQL database password */
define('DB_PASSWORD', 'o7$6b2TwSO');

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '0pe06;/L;[K#axS;27X+V]_4:R-g6NdEy_H0|OOk:GSWU1%GI3R/+5O;V7PJ;A54');
define('SECURE_AUTH_KEY', '(7GYN5-Z2H90S84261]pC(+18!&M9/9:)(6FT%5:]o%b+14O4j!TBC|gGh19(gd2');
define('LOGGED_IN_KEY', '7C~EDe@urxAi!*h9c#wv5yW1a)m0pg8Q!Xt@[TGMDo_(w5#)9pcZHotqLHw19-B5');
define('NONCE_KEY', 'ZA*[%5yW3:ne|28Dqn!Cnw&A!n-a6[[(7+y6vD_bLfrZ1Hxz3r|;@rMWk08A8qs0');
define('AUTH_SALT', '4jF78h4Schfc5+M:FLaQ*C|0Y-;81705_Gz2Vvk2r@4:i4%3nGb2Jf_7!%|C(KZv');
define('SECURE_AUTH_SALT', '!(d|J9fU~%8)B(4#jl|[K45@E&4o-6(#32@)34H[2Xh0gPF677P8qqW59:j7~7]c');
define('LOGGED_IN_SALT', 'x*25Nd4K18HEI#~%dR&B8;~+|4N+vg6a_u[[8eBUrk#5i*@ra57cRHnUvUy@4A1E');
define('NONCE_SALT', '1WM7:9v@8nO&-SR44t:%_s__@WY_--N3VGk4dNZ#b@lUi3(@Gqn2u4#btAzS(]~@');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '5gx0Q_';

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

define('WP_ALLOW_MULTISITE', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
