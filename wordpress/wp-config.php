<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pavimpre_wp1');

/** MySQL database username */
define('DB_USER', 'pavimpre_wp1');

/** MySQL database password */
define('DB_PASSWORD', 'L)UEp5]wM#68^[2');

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
define('AUTH_KEY',         'HYrXWQ5ATktdgGQAizuG69YQFGmlHTI0NatdPB7XneiYAPZDE4ayYncxdjr7kD8e');
define('SECURE_AUTH_KEY',  'NKBBKrR57yfygw3iY8V8QbZcLzWVpVETELL131zB5uciic1UsliHBzwP2gUmuSLw');
define('LOGGED_IN_KEY',    '7N9VaRCwwfs46UPyZ41jyLiNJBunWmlA1wDjhnat2NdaJ0qsdNKBDXzP4iJF7yon');
define('NONCE_KEY',        'Zv9lZQ5DfDW1QyE9rsX68eghzr0H2Y2X2wDycXWDF4DqLyUVDUpLYPZi2yARCP8y');
define('AUTH_SALT',        'uDV3st1aXLYCAL998iYSTRDkkurPsMt2tAXRBHWEDDVr8pQTHrAstfI2URHtRN1s');
define('SECURE_AUTH_SALT', '53iGrCA38tRIKnLGSTe1UXOvA5nxZLxVFikzC6HevoMN4CZq8Nt33MaWoClpaaB6');
define('LOGGED_IN_SALT',   'eta6aQzTaVqLL5zXmLHE9GEJrCQSfXk7t9Px8M0BLFB85mCMaTcHPufuKBr4HqKU');
define('NONCE_SALT',       'WIJr0WtALdRZz1NvKtNZXbKtGGPczqt7OiwePKTZcFsQo64LpH7cpYKbykd5KHA4');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
