<?php

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class
 */
class ssb_main {

	/**
	 * @var object $ui
	 */
	public $ui;


	/**
	 * Plugin settings
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Constructor - Initialize the plugin
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Initialize UI object
		$this->ui = new ssb_ui();

		// Pull stored data
		$this->settings = get_option( 'ssb_settings', array() );

		// Hook into WordPress
		$this->init_hooks();
	}

	/**
	 * Initialize WordPress hooks
	 *
	 * @since 2.0.0
	 */
	private function init_hooks() {
		// Migration
		add_action( 'init', array( $this, 'ssb_icons_migration' ) );

		// Plugin text domain
		add_action( 'init', array( $this, 'ssb_textdomain' ) );

		// Register settings
		add_action( 'admin_init', array( $this, 'ssb_register_settings' ) );

		// Admin menu
		add_action( 'admin_menu', array( $this, 'ssb_admin_menu' ) );

		// Admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'ssb_admin_assets' ) );

		// Admin notices
		add_action( 'admin_notices', array( $this, 'ssb_admin_notices' ) );

		// Frontend assets and display
		add_action( 'wp_enqueue_scripts', array( $this, 'ssb_ui_assets' ) );
		add_action( 'wp_footer', array( $this->ui, 'icons' ) );
	}



	/**
	 * Load text domain
	 *
	 * @since 1.0
	 */
	public function ssb_textdomain() {

		load_plugin_textdomain( 'sticky-side-buttons', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	}


	/**
	 * Register settings
	 *
	 * @since 1.0
	 */
	public function ssb_register_settings() {

		register_setting( 'ssb_storage', 'ssb_settings', array(
			'sanitize_callback' => array( $this, 'sanitize_settings' )
		) );
		register_setting( 'ssb_storage', 'ssb_buttons', array(
			'sanitize_callback' => array( $this, 'sanitize_buttons' )
		) );
		register_setting( 'ssb_storage', 'ssb_showoncpt', array(
			'sanitize_callback' => array( $this, 'sanitize_show_on_cpt' )
		) );

	}


	/**
	 * Admin menu
	 *
	 * @since 1.0
	 */
	public function ssb_admin_menu() {

		add_menu_page(
			__( 'Sticky Side Buttons', 'sticky-side-buttons' ),
			__( 'Sticky Side Buttons', 'sticky-side-buttons' ),
			'manage_options',
			'ssb',
			array(
				$this->ui,
				'admin_page'
			),
			'dashicons-list-view'
		);

	}


	/**
	 * Admin assets - Load CSS and JS for admin pages
	 *
	 * @since 1.0
	 * @param string $hook_suffix Current admin page hook suffix
	 */
	public function ssb_admin_assets( $hook_suffix ) {

		// Only load on our plugin's admin page
		if ( 'toplevel_page_ssb' !== $hook_suffix ) {
			return;
		}

		$plugin_version = $this->get_plugin_version();

		// CSS
		wp_enqueue_style( 
			'ssb-admin-style', 
			plugins_url( 'assets/css/ssb-admin-style.css', __FILE__ ), 
			array(), 
			$plugin_version 
		);
		// Use latest FontAwesome 6.7.2 from CDN for better performance and updates
		wp_enqueue_style( 
			'ssb-fontawesome', 
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css', 
			array(), 
			'6.7.2' 
		);
		wp_enqueue_style( 
			'ssb-iconpicker', 
			plugins_url( 'assets/css/fontawesome-iconpicker.css', __FILE__ ), 
			array( 'ssb-fontawesome' ), 
			$plugin_version 
		);
		wp_enqueue_style( 'wp-color-picker' );

		// JS
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 
			'ssb-iconpicker-js', 
			plugins_url( 'assets/js/fontawesome-iconpicker.js', __FILE__ ), 
			array( 'jquery' ), 
			$plugin_version, 
			true 
		);
		wp_enqueue_script( 
			'ssb-admin-js', 
			plugins_url( 'assets/js/ssb-admin-js.js', __FILE__ ), 
			array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker', 'ssb-iconpicker-js' ), 
			$plugin_version, 
			true 
		);

	}


	/**
	 * Admin notices
	 *
	 * @since 1.0
	 */
	public function ssb_admin_notices() {

		// Get current screen
		$screen = get_current_screen();

		/**
		 * If settings updated successfully
		 */
		if ( isset( $_GET['settings-updated'] ) && $screen->id == 'toplevel_page_ssb' ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Changes have been saved successfully!', 'sticky-side-buttons' ); ?></p>
			</div>
			<?php
		}

	}


	/**
	 * Frontend UI Assets
	 *
	 * @since 1.0
	 */
	public function ssb_ui_assets() {

		$plugin_version = $this->get_plugin_version();

		// CSS
		wp_enqueue_style( 
			'ssb-ui-style', 
			plugins_url( 'assets/css/ssb-ui-style.css', __FILE__ ), 
			array(), 
			$plugin_version 
		);
		// Use latest FontAwesome 6.7.2 from CDN for better performance and updates
		wp_enqueue_style( 
			'ssb-fontawesome-frontend', 
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css', 
			array(), 
			'6.7.2' 
		);

		// Generate dynamic CSS for button styling
		$dynamic_css = $this->generate_dynamic_css();
		if ( ! empty( $dynamic_css ) ) {
			wp_add_inline_style( 'ssb-ui-style', $dynamic_css );
		}

		// JS
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-effects-shake' );
		wp_enqueue_script( 
			'ssb-ui-js', 
			plugins_url( 'assets/js/ssb-ui-js.js', __FILE__ ), 
			array( 'jquery', 'jquery-ui-core', 'jquery-effects-shake' ), 
			$plugin_version, 
			true 
		);

		// Pass data to JavaScript
		$btn_z_index = isset( $this->settings['btn_z_index'] ) ? absint( $this->settings['btn_z_index'] ) : 1;
		wp_localize_script( 'ssb-ui-js', 'ssb_ui_data', array(
			'z_index' => $btn_z_index,
			'nonce'   => wp_create_nonce( 'ssb_frontend_nonce' )
		) );
	}


	/**
     * Icons migration to newer version 
     * 
     * @since 1.0.8
     * @since 2.0.0 Added proper validation and safety checks
     */
	public function ssb_icons_migration() {

		// Check if migration already completed
		if ( get_option( 'ssb_icons_migrated', false ) ) {
			return;
		}

	    // Get old buttons
	    $buttons = get_option( 'ssb_buttons' );

	    // Validate buttons data exists and is properly structured
	    if ( ! is_array( $buttons ) || ! isset( $buttons['btns'] ) || ! is_array( $buttons['btns'] ) ) {
	    	// Mark as migrated even if no data to migrate
	    	update_option( 'ssb_icons_migrated', true );
	        return;
	    }

	    $updated = false;

	    // Replace them - iterate through actual button IDs, not numeric indexes
	    foreach ( $buttons['btns'] as $btn_id => $button_data ) {
	    	if ( ! is_array( $button_data ) || ! isset( $button_data['btn_icon'] ) ) {
	    		continue;
	    	}

	    	$icon = $button_data['btn_icon'];
	    	
	    	// Only migrate if it's not already prefixed and not empty
	    	if ( ! empty( $icon ) && 
	    		 strpos( $icon, 'fas' ) === false && 
	    		 strpos( $icon, 'far' ) === false && 
	    		 strpos( $icon, 'fab' ) === false ) {
	    		
		        $buttons['btns'][ $btn_id ]['btn_icon'] = 'fas ' . $icon;
		        $updated = true;
            }
        }

        // Only update if we made changes
        if ( $updated ) {
			update_option( 'ssb_buttons', $buttons );
		}

		// Mark migration as completed
		update_option( 'ssb_icons_migrated', true );
    }

	/**
	 * Sanitize settings input
	 *
	 * @since 2.0.0
	 * @param array $input Raw input data
	 * @return array Sanitized data
	 */
	public function sanitize_settings( $input ) {
		if ( ! is_array( $input ) ) {
			return array();
		}

		$sanitized = array();
		
		// Sanitize boolean values
		$boolean_fields = array( 'show_on_frontpage', 'show_on_posts', 'show_on_pages', 'disable_mobile' );
		foreach ( $boolean_fields as $field ) {
			$sanitized[ $field ] = isset( $input[ $field ] ) ? 1 : 0;
		}

		// Sanitize text fields
		if ( isset( $input['btn_z_index'] ) ) {
			$sanitized['btn_z_index'] = absint( $input['btn_z_index'] );
		}

		if ( isset( $input['btn_pos'] ) ) {
			$sanitized['btn_pos'] = in_array( $input['btn_pos'], array( 'left', 'right' ) ) ? $input['btn_pos'] : 'right';
		}

		if ( isset( $input['btn_hover'] ) ) {
			$allowed_hover = array( 'dark', 'light' );
			$sanitized['btn_hover'] = in_array( $input['btn_hover'], $allowed_hover ) ? $input['btn_hover'] : 'dark';
		}

		if ( isset( $input['btn_anim'] ) ) {
			$allowed_animations = array( 'none', 'slide', 'icons' );
			$sanitized['btn_anim'] = in_array( $input['btn_anim'], $allowed_animations ) ? $input['btn_anim'] : 'none';
		}

		if ( isset( $input['btn_share'] ) ) {
			$sanitized['btn_share'] = 1;
		}

		if ( isset( $input['btn_disable_mobile'] ) ) {
			$sanitized['btn_disable_mobile'] = 1;
		}

		return $sanitized;
	}

	/**
	 * Sanitize buttons input
	 *
	 * @since 2.0.0
	 * @param array $input Raw input data
	 * @return array Sanitized data
	 */
	public function sanitize_buttons( $input ) {
		if ( ! is_array( $input ) ) {
			return array();
		}

		$sanitized = array();

		if ( isset( $input['btns_order'] ) ) {
			$sanitized['btns_order'] = sanitize_text_field( $input['btns_order'] );
		}

		if ( isset( $input['btns'] ) && is_array( $input['btns'] ) ) {
			$sanitized['btns'] = array();
			
			foreach ( $input['btns'] as $key => $button ) {
				if ( ! is_array( $button ) ) {
					continue;
				}

				$sanitized_button = array();
				$sanitized_button['btn_text'] = isset( $button['btn_text'] ) ? sanitize_text_field( $button['btn_text'] ) : '';
				$sanitized_button['btn_link'] = isset( $button['btn_link'] ) ? esc_url_raw( $button['btn_link'] ) : '';
				$sanitized_button['btn_icon'] = isset( $button['btn_icon'] ) ? sanitize_text_field( $button['btn_icon'] ) : '';
				$sanitized_button['btn_color'] = isset( $button['btn_color'] ) ? sanitize_hex_color( $button['btn_color'] ) : '#000000';
				$sanitized_button['btn_font_color'] = isset( $button['btn_font_color'] ) ? sanitize_hex_color( $button['btn_font_color'] ) : '#ffffff';
				$sanitized_button['open_new_window'] = isset( $button['open_new_window'] ) ? 1 : 0;

				$sanitized['btns'][ $key ] = $sanitized_button;
			}
		}

		return $sanitized;
	}

	/**
	 * Sanitize show on CPT input
	 *
	 * @since 2.0.0
	 * @param array $input Raw input data
	 * @return array Sanitized data
	 */
	public function sanitize_show_on_cpt( $input ) {
		if ( ! is_array( $input ) ) {
			return array();
		}

		$sanitized = array();
		$registered_cpts = get_post_types( array( '_builtin' => false ), 'names' );

		foreach ( $input as $cpt ) {
			$cpt = sanitize_text_field( $cpt );
			if ( in_array( $cpt, $registered_cpts ) ) {
				$sanitized[] = $cpt;
			}
		}

		return $sanitized;
	}

	/**
	 * Get plugin version from header
	 *
	 * @since 2.0.0
	 * @return string Plugin version
	 */
	private function get_plugin_version() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		
		$plugin_data = get_plugin_data( dirname( __FILE__ ) . '/sticky-side-buttons.php' );
		return $plugin_data['Version'] ?? '2.0.0';
	}

	/**
	 * Generate dynamic CSS for button styling
	 *
	 * @since 2.0.0
	 * @return string Generated CSS
	 */
	private function generate_dynamic_css() {
		$dynamic_css = '';

		if ( empty( $this->ui->buttons['btns'] ) || ! is_array( $this->ui->buttons['btns'] ) ) {
			return $dynamic_css;
		}

		foreach ( $this->ui->btns_order as $btn_key => $btn_id ) {
			if ( ! isset( $this->ui->buttons['btns'][ $btn_id ] ) ) {
				continue;
			}

			$button = $this->ui->buttons['btns'][ $btn_id ];
			
			// Validate hex color
			$btn_color = sanitize_hex_color( $button['btn_color'] ?? '#000000' );
			$font_color = sanitize_hex_color( $button['btn_font_color'] ?? '#ffffff' );

			if ( ! $btn_color ) {
				$btn_color = '#000000';
			}
			if ( ! $font_color ) {
				$font_color = '#ffffff';
			}

			// Convert hex to RGB for hover effect
			$hex = str_replace( '#', '', $btn_color );
			if ( strlen( $hex ) === 6 ) {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );

				$btn_id_clean = sanitize_html_class( $btn_id );
				
				$dynamic_css .= sprintf(
					'#ssb-btn-%s{background: %s;}' . PHP_EOL .
					'#ssb-btn-%s:hover{background:rgba(%d,%d,%d,0.9);}' . PHP_EOL .
					'#ssb-btn-%s a{color: %s;}' . PHP_EOL,
					$btn_id_clean, $btn_color,
					$btn_id_clean, $r, $g, $b,
					$btn_id_clean, $font_color
				);

				// Share button color (first button)
				if ( $btn_key === 0 ) {
					$dynamic_css .= sprintf(
						'.ssb-share-btn,.ssb-share-btn .ssb-social-popup{background:%s;color:%s}' . PHP_EOL .
						'.ssb-share-btn:hover{background:rgba(%d,%d,%d,0.9);}' . PHP_EOL .
						'.ssb-share-btn a{color:%s !important;}' . PHP_EOL,
						$btn_color, $font_color,
						$r, $g, $b,
						$font_color
					);
				}
			}
		}

		return $dynamic_css;
	}

}
