<?php
/**
 * @package Rtcamp_Post_Authors
 * @version 1.0.0
 */
/*
Plugin Name: Rtcamp Post Authors
Plugin URI: http://rajanlama.com.np/plugins/rtcamp-post-authors/
Description: This is just a demo plugins for Rtcamp to display a multiple post authors.
Author: Rajan Lama
Version: 1.0.0
Author URI: http://rajanlama.com.np
*/

require_once plugin_dir_path(__FILE__) . 'includes/helper.php';


function rpa_enqueue_script()
{
    wp_enqueue_style('rpa-style', plugin_dir_url(__FILE__). 'css/style.css');
}
add_action('wp_enqueue_scripts', 'rpa_enqueue_script');