<?php
/*
Plugin Name: Job Listing
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Basic WordPress Plugin Header Comment
Version:     1.0
Author:      WordPress.org
Author URI:  https://developer.wordpress.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

//Exit if accessed directly

if(!defined('ABSPATH')){
	exit;
}
require_once(plugin_dir_path(__FILE__).'wp_job_cpt.php');
require_once(plugin_dir_path(__FILE__).'wp-job-fields.php');
require_once(plugin_dir_path(__FILE__).'wp_job_render_admin.php');
require_once(plugin_dir_path(__FILE__).'wp_job_shortcode.php');


function dwwp_admin_enqueue_scripts(){
	global $pagenow,$typenow;

	if(($pagenow=='post.php' || pagenow=='post-new.php') && $typenow=='job'){
		wp_enqueue_style('dwwp-admin-css',plugins_url('css/admin-jobs.css', __FILE__ ));
		wp_enqueue_style('bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css');
		wp_enqueue_script('dwwp-job-js', plugins_url('js/admin-jobs.js', __FILE__ ), array('jquery','jquery-ui-datepicker','bootstrap'), '20150204', true);
		wp_enqueue_script('dwwp-custom-quicktags', plugins_url('js/dwwp-quicktags.js', __FILE__), array('quicktags'), '20150206', true);
		wp_enqueue_style('jquery-style','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/smoothness/jquery-ui.css');
	}
}
add_action('admin_enqueue_scripts','dwwp_admin_enqueue_scripts');