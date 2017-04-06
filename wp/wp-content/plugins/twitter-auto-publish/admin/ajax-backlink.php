<?php

add_action('wp_ajax_xyz_twap_ajax_backlink', 'xyz_twap_ajax_backlink_call');

function xyz_twap_ajax_backlink_call() {


	global $wpdb;

	if($_POST){

		update_option('xyz_credit_link','twap');
	}
	die();
}


?>