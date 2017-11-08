<?php
/*
Plugin Name: Vendi Theme-Level Notifications
Description: Adds notification support to themes.
Version: 1.0.0
Author: Vendi Advertising (Chris Haas)
Author URI: http://www.vendiadvertising.com/
*/

global $vendi_theme_notifications;
$vendi_theme_notifications = array();

define( 'VENDI_NOTIFICATIONS_FILE', __FILE__ );
define( 'VENDI_NOTIFICATIONS_PATH', dirname( __FILE__ ) );
define( 'VENDI_NOTIFICATIONS_URL',  plugin_dir_url( __FILE__ ) );

require_once 'src/vendi-notifications.php';
