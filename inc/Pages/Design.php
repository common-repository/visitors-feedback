<?php
namespace VSTR\Pages;

class Design{

    function register(){
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
		add_action('admin_menu', [$this, 'admin_menu']);
		add_action( 'admin_init', [$this, 'register_my_setting'] );
		add_action( 'rest_api_init', [$this, 'register_my_setting'] );
    }

	function register_my_setting() {
		register_setting( 'vstr_popup_design', 'vstr_settings', array(
			'show_in_rest' => array(
				'name' => 'vstr_popup_design',
				'schema' => array(
					'type'  => 'string',
				),
			),
			'type' => 'string',
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
		) ); 
	} 

	/**
	 * enqueue admin assets
	 */
	function admin_enqueue_scripts($hook){
		wp_enqueue_script('vstr-settings',VSTR_DIR.'dist/settings.js', ['wp-components', 'wp-block-editor', 'wp-api' ], '1.0.0');
		wp_enqueue_style('vstr-settings', VSTR_DIR.'dist/settings.css', ['wp-components'], '1.0.0');
	}


	/**
	 * create main Visitor Feedback menu and Design page
	 */
	function admin_menu(){

		add_menu_page( __("Visitor Feedback Settings", "visitor-feedback"), __("Visitor Feedback", "visitor-feedback"), 'manage_options', 'visitor-feedback-settings', [$this, 'page_callback'], 'dashicons-feedback', 14 );

		add_submenu_page(
            'visitor-feedback-settings',
            __( 'Design', 'visitor-feedback' ),
            __( 'Design', 'visitor-feedback' ),
            'manage_options',
            'visitor-feedback-settings',
            null,
            '5',
        );
	}

	/**
	 * design page body
	 */
	function page_callback(){
		?>
        <div id="vstr_settings_page"></div>
        <?php
	}

}