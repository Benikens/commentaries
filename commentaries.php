<?php
/*
Plugin Name: Commentaries
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Handles uploading and outputing Commentaries
Version:  1.0
Author: Benjamin Russell
Author URI: http:/
License: GPL2
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require 'custom-functions.php';
register_activation_hook( __FILE__, 'coms_all_install' );
register_activation_hook( __FILE__, 'coms_all_install_data' );

/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
	add_menu_page( 'Commentary Upload', 'Commentary Uploader', 'manage_options', 'commentaries', 'commentaries_upload' );
}

/** Step 3. */
function commentaries_upload() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
  require 'admin-form.php';
}


// // Update CSS within in Admin
// function uploader_style() {
//   wp_enqueue_style('uploader-styles', plugins_url('', __FILE__).'/uploader.css');
// }
// add_action('uploader_enqueue_scripts', 'uploader_style');

//Shortcodes, needs to output the most recent single commentary or return a filterable list of the rest
function comment_func( $atts) {
  $a = shortcode_atts( array(
      'type' => 'type',
      'list' => false
    ), $atts );
  if($a['list'] == true){
    echo commentaryList($a['type']);
  } else {
		echo latestCommentary($a['type']);
    //echo commentarySingle($a['type']);
  }
}
add_shortcode( 'asset', 'comment_func' );

function urlFunc(){

}
//
// // Maybe a list of types stored in a db?
// function typesHandler(){
//
// }


// not needed just to remember file functions
// function csvDownload($csvFileName, $url){
//   $xml4csv = new SimpleXMLElement($url, null, true);
//   $current = file_get_contents($csvFileName);
//   $current .= "PRODUCT,APPLICATION,REDEMPTION,EFFECTIVE DATE\n";
//   foreach ($xml4csv->asset as $asset) {
//     $current .= "Daintree Core Income Trust,".(string)$asset->buyPrice.",".(string)$asset->sellPrice.",".(string)$asset->effectiveDate."\n";
//   }
//   file_put_contents($csvFileName, $current);
// }
?>
