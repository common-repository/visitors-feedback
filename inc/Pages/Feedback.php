<?php
namespace VSTR\Pages;

class Feedback{

    function register(){
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
		add_action('admin_menu', [$this, 'admin_menu']);
    }

	/**
	 * enqueue admin assets
	 */
	function admin_enqueue_scripts($hook){
		wp_enqueue_script('vstr-feedbacks',VSTR_DIR.'dist/feedbacks.js', ['wp-components', 'wp-block-editor', 'wp-api' ], '1.0.0');
		wp_enqueue_style('vstr-feedbacks', VSTR_DIR.'dist/feedbacks.css', ['wp-components'], '1.0.0');
	}


	/**
	 * 
	 */
	function admin_menu(){
		add_submenu_page( 'visitor-feedback-settings', __("Feedbacks", "visitor-feedback"), __("Feedbacks", "visitor-feedback"), 'manage_options', 'vstr-feedbacks', [$this, 'page_callback'], 14 );
	}

	function page_callback(){
		?>
        <div id="vstr_feedbacks"></div>
        <?php
	}

}

