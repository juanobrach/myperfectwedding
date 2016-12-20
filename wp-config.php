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
define('DB_NAME', 'myperf20_db');

/** MySQL database username */
define('DB_USER', 'myperf20_wedding');

/** MySQL database password */
define('DB_PASSWORD', 'dl7@S7@7PY');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_HOME','http://www.myperfectweddingmexico.com/');
define('WP_SITEURL','http://www.myperfectweddingmexico.com/');


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ymura6yrvthiqwfst3papi166e9flmgtzplnhtaudosrk8ghwovvhfoi8qobqlxt');
define('SECURE_AUTH_KEY',  'y4ej7ggkrwogaabpoa2lkkncpnbjbhp0k8zt3xo7jj93cr9jad6sllfmuzh6kqm2');
define('LOGGED_IN_KEY',    'cbuonlhn5na6wlfvogratxjvqhenr8ohxnlkzg8dzybkl3dignecwvbsymsndww3');
define('NONCE_KEY',        '149f1bbfm87cci5rmez1au6lpmaqexy2uwa5aydnvmlljod3vdq9nhakrpxzn623');
define('AUTH_SALT',        'okwfwzlrm4zjtfoi1mpbqrv5twgstadabg3oormbytjdrasdjlt0fxhrmxksky1a');
define('SECURE_AUTH_SALT', 'fgwjbrmczrvxnpsi6ktdkeloe3mp6g4xsnxvqesn6nq4mg1zatjjhqhaffafyjfl');
define('LOGGED_IN_SALT',   '3ycgwckxem4eegfgslzfxbspglnal1wdor7djkp9h2r8an3amdo1qkckj8qz2soa');
define('NONCE_SALT',       'kkcftnosqe2t0qei77v3zyhyyhu9eeaoaivgvrcdipkjovl82m4q1znz6oxepfbi');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpds_';

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
define('WP_DEBUG', false);
define( 'WP_AUTO_UPDATE_CORE', false );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_HOME','myperfectweddingmexico.com');
define('WP_SITEURL','myperfectweddingmexico.com');
