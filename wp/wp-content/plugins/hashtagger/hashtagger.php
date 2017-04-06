<?php
/*
Plugin Name: hashtagger
Plugin URI: http://petersplugins.com/free-wordpress-plugins/hashtagger/
Description: Tag your posts by using #hashtags
Version: 3.5
Author: Peter's Plugins, smartware.cc
Author URI: http://petersplugins.com
Text Domain: hashtagger
License: GPL2+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . '/inc/class-hashtagger.php' );

$hashtagger = new Hashtagger( __FILE__ );

// this function can be used in theme
// does all the hashtagger stuff on a string
function do_hashtagger( $content ) {
  $htg = new Hashtagger();
  return $htg->work( $content );
}
?>