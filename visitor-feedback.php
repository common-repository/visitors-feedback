<?php
/**
 * Plugin Name: Exit Intent Visitors Feedback
 * Description: Capture valuable feedback from your website visitors before they leave.
 * Version: 1.0.1
 * Author: bPlugins
 * Author URI: http://bplugins.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: visitor-feedback
 */

if ( !defined( 'ABSPATH' ) ) { exit; }

// Constant
define( 'VSTR_VER', isset( $_SERVER['HTTP_HOST'] ) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.0.0' );
define( 'VSTR_DIR', plugin_dir_url( __FILE__ ));


if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once(dirname(__FILE__).'/vendor/autoload.php');
}

class VisitorFeedback{
	
	function __construct(){
        add_action('wp_footer', [$this, 'add_html_code_on_footer']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
		add_action('plugins_loaded', [$this, 'plugins_loaded']);
	}

	function plugins_loaded(){
		if(class_exists('VSTR\\Init')){
			VSTR\Init::register_services();
		}
	}

    function enqueue_assets(){
        wp_enqueue_style('visitor-feedback', VSTR_DIR.'dist/style.css', [], VSTR_VER);
        wp_enqueue_script('visitor-feedback', VSTR_DIR.'dist/script.js', ['react', 'react-dom','wp-api'], VSTR_VER);
    }

    function add_html_code_on_footer(){
        ?>
        <div id="vstr_feedback"></div>
        <?php
    }
}
new VisitorFeedback;
