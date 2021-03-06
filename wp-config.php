<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'gh.01' );

/** MySQL database username */
define( 'DB_USER', 'tcuong' );

/** MySQL database password */
define( 'DB_PASSWORD', 'cuong123@' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'ad@O#gybjes^r2~R_+c,WVOX}.HRLL=dwmY4`Kw-,&G&5D=Tuf[5]B+=cg5rO![V' );
define( 'SECURE_AUTH_KEY',   'p6cfdYb9Z.ni^=<9S!A5ZGH[<w]raU|ykh*=[oR_DzI.nPV`QO!D!ai4}){dD4e,' );
define( 'LOGGED_IN_KEY',     'iGebW8jsrn;yBk_,]Kg8N(;o8P]j>p$9O_kK81Rsnd &::6<E51iUTn!*)xafqW&' );
define( 'NONCE_KEY',         'G2fz`g|`{|l?^NZ?0T|!zj8|,A*4 #a$TDulE+HJ7ok=nu;SN2gwB&W nd^,ed,!' );
define( 'AUTH_SALT',         '(@ Y.Yu{L,jmS[+T0-4/33vm9p}F=P`3J0`Y>h%iq;,kL!0To!#9I)* b,v@!L_@' );
define( 'SECURE_AUTH_SALT',  'sO]vT|LRUzXpv!{:^]B[t@$JaSPeamgv(5Oq!+sYP#W1ZmRMJ=;lj2EBr?gwn2O)' );
define( 'LOGGED_IN_SALT',    'sN>kL<.=FABX#<5_6RIAlqDvjzlj~i@ (yZC(&~kJ!k9~5yiB^BRWT9 }:EQjyX]' );
define( 'NONCE_SALT',        'g#)IF;DBUrTv33~x[vZ@dlUQylVFU]^znH:1vnwaN*737t@37.~Ug|{LJ/7c[d <' );
define( 'WP_CACHE_KEY_SALT', '>3`grLAk/XWb@9e=A+Z<:#l{?#iE_@uBJt?&_4D~8Lp~3 $P|ZI&/-b0>Fp)nJq,' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
