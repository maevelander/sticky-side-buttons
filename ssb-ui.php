<?php

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sticky Side Buttons UIs
 *
 * User Interface class which will contain
 * UI for the front and admin panel
 */
class ssb_ui {

	/**
	 * @var array $buttons
	 * @var array $settings
	 */
	public $buttons;
	public $settings;
	public $btns_order;
	public $cpts;
	public $showoncpt;

	/**
	 * Dump everything for this class here
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Pull stored data
		$this->buttons   = get_option( 'ssb_buttons' );
		$this->settings  = get_option( 'ssb_settings' );
		$this->showoncpt = get_option( 'ssb_showoncpt' );

		// Buttons Sorting - with safety checks
		if ( isset( $this->buttons['btns_order'] ) && ! empty( $this->buttons['btns_order'] ) ) {
			$this->btns_order = explode( '&', str_replace( 'sort=', '', $this->buttons['btns_order'] ) );
			// Remove empty values
			$this->btns_order = array_filter( $this->btns_order );
		} else {
			$this->btns_order = array();
		}

	}


	/**
	 * Admin Page UI
	 *
	 * @since 1.0
	 */
	public function admin_page() {
		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'sticky-side-buttons' ) );
		}
		?>
        <div class="wrap" id="ssb-wrap">
            <h1>
				<?php echo esc_html( get_admin_page_title() ); ?>
            </h1>
            <form method="post" action="options.php">
				<?php

				// Button builder
				$this->button_builder();

				// General settings
				$this->general_settings();

				?>
            </form>
        </div>
		<?php
	}


	/**
	 * Button Builder UI Part
	 *
	 * @since 1.0
	 */
	public function button_builder() {
		?>
        <div class="ssb-panel">
			<?php settings_fields( 'ssb_storage' ); ?>
            <input type="hidden" name="ssb_buttons[btns_order]" id="ssb-btns-order"
                   value="<?php echo esc_attr( $this->buttons['btns_order'] ); ?>">
            <header class="ssb-panel-header">
				<?php _e( 'Button Builder', 'sticky-side-buttons' ); ?>
            </header>
            <div class="ssb-panel-body">
                <p><?php _e( 'Add buttons then drag and drop to reorder them. Click the arrow on the right of each item to reveal more configuration options.', 'sticky-side-buttons' ); ?></p>
                <p><a href="#" class="button ssb-add-btn"><?php _e( 'Add Button', 'sticky-side-buttons' ); ?></a></p>

                <ul id="ssb-sortable-buttons">
					<?php

					// Buttons exists
					if ( isset( $this->buttons['btns'] ) ) {

						// Buttons loop + ordering
						foreach ( $this->btns_order AS $btn_key => $btn_id ) {

							?>
                            <li id="ssb_btn_<?php echo esc_attr( $btn_id ); ?>">
                                <header role="button" 
                                        aria-expanded="false" 
                                        aria-controls="button-settings-<?php echo esc_attr( $btn_id ); ?>"
                                        tabindex="0">
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
									<?php echo esc_html( $this->buttons['btns'][ $btn_id ]['btn_text'] ); ?>
                                </header>
                                <div class="ssb-btn-body" id="button-settings-<?php echo esc_attr( $btn_id ); ?>" role="region" aria-label="<?php esc_attr_e( 'Button settings', 'sticky-side-buttons' ); ?>">
                                    <div class="ssb-body-left">
                                        <p>
                                            <label for="button-text-<?php echo esc_attr( $btn_id ); ?>">Button Text</label>
                                            <input type="text"
                                                   id="button-text-<?php echo esc_attr( $btn_id ); ?>"
                                                   class="widefat"
                                                   name="ssb_buttons[btns][<?php echo esc_attr( $btn_id ); ?>][btn_text]"
                                                   value="<?php echo esc_attr( $this->buttons['btns'][ $btn_id ]['btn_text'] ); ?>">
                                        </p>
                                        <p class="ssb-iconpicker-container">
                                            <label for="button-icon-<?php echo esc_attr( $btn_id ); ?>">Button icon</label>
                                            <input type="text"
                                                   id="button-icon-<?php echo esc_attr( $btn_id ); ?>"
                                                   class="widefat ssb-iconpicker"
                                                   data-placement="bottomRight"
                                                   name="ssb_buttons[btns][<?php echo esc_attr( $btn_id ); ?>][btn_icon]"
                                                   value="<?php echo esc_attr( $this->buttons['btns'][ $btn_id ]['btn_icon'] ); ?>"
                                                   aria-describedby="button-icon-help-<?php echo esc_attr( $btn_id ); ?>">
                                            <span class="ssb-icon-preview input-group-addon"></span>
                                            <span id="button-icon-help-<?php echo esc_attr( $btn_id ); ?>" class="description">
                                                <?php esc_html_e( 'FontAwesome icon class (e.g., fas fa-phone)', 'sticky-side-buttons' ); ?>
                                            </span>
                                        </p>
                                        <p>
                                            <label for="button-link-<?php echo esc_attr( $btn_id ); ?>">link URL</label>
                                            <input type="text"
                                                   id="button-link-<?php echo esc_attr( $btn_id ); ?>"
                                                   class="widefat"
                                                   name="ssb_buttons[btns][<?php echo esc_attr( $btn_id ); ?>][btn_link]"
                                                   value="<?php echo esc_url( $this->buttons['btns'][ $btn_id ]['btn_link'] ); ?>">
                                        </p>
                                    </div>
                                    <div class="ssb-body-right">
                                        <p>
                                            <label for="button-color-<?php echo esc_attr( $btn_id ); ?>">Button Color</label>
                                            <input type="text"
                                                   id="button-color-<?php echo esc_attr( $btn_id ); ?>"
                                                   class="widefat ssb-colorpicker"
                                                   name="ssb_buttons[btns][<?php echo esc_attr( $btn_id ); ?>][btn_color]"
                                                   value="<?php echo esc_attr( $this->buttons['btns'][ $btn_id ]['btn_color'] ); ?>">
                                        </p>
                                        <p>
                                            <label for="button-font-color-<?php echo esc_attr( $btn_id ); ?>">font color</label>
                                            <input type="text"
                                                   id="button-font-color-<?php echo esc_attr( $btn_id ); ?>"
                                                   class="widefat ssb-colorpicker"
                                                   name="ssb_buttons[btns][<?php echo esc_attr( $btn_id ); ?>][btn_font_color]"
                                                   value="<?php echo esc_attr( $this->buttons['btns'][ $btn_id ]['btn_font_color'] ); ?>">
                                        </p>
                                        <p>
                                            <label for="button-opening-<?php echo esc_attr( $btn_id ); ?>"
                                                   style="text-transform: inherit">Open link in a new window</label>
                                            <input type="checkbox"
                                                   id="button-opening-<?php echo esc_attr( $btn_id ); ?>"
                                                   class="open-new-window"
                                                   name="ssb_buttons[btns][<?php echo esc_attr( $btn_id ); ?>][open_new_window]"
                                                   value="1"
												<?php checked( isset( $this->buttons['btns'][ $btn_id ]['open_new_window'] ) && $this->buttons['btns'][ $btn_id ]['open_new_window'] == 1 ); ?>>
                                        </p>
                                    </div>
                                    <div class="ssb-btn-controls">
                                        <a href="#" class="ssb-remove-btn">Remove</a> |
                                        <a href="#" class="ssb-close-btn">Close</a>
                                    </div>
                                </div>
                            </li>
							<?php
						}
					}
					?>
                </ul>

            </div>
            <footer class="ssb-panel-footer">
                <input type="submit" class="button-primary"
                       value="<?php _e( 'Save Buttons', 'sticky-side-buttons' ); ?>">
            </footer>
        </div>
		<?php
		return true;
	}


	/**
	 * General Settings UI Part
	 *
	 * @since 1.0
	 */
	public
	function general_settings() {
		?>
        <div class="ssb-panel">
			<?php settings_fields( 'ssb_storage' ); ?>
            <header class="ssb-panel-header">
				<?php _e( 'General Settings', 'sticky-side-buttons' ); ?>
            </header>
            <div class="ssb-panel-body">
                <div class="ssb-row">
                    <div class="ssb-col">
                        <label for="ssb-pos-left">
                            <strong><?php _e( 'Button Position', 'sticky-side-buttons' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-pos-left">
                            <input type="radio"
                                   name="ssb_settings[btn_pos]"
                                   id="ssb-pos-left"
                                   value="left"
								<?php checked( isset( $this->settings['btn_pos'] ) && $this->settings['btn_pos'] == 'left' ); ?>>
							<?php _e( 'Left', 'sticky-side-buttons' ); ?>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-pos-right">
                            <input type="radio"
                                   name="ssb_settings[btn_pos]"
                                   id="ssb-pos-right"
                                   value="right"
								<?php checked( isset( $this->settings['btn_pos'] ) && $this->settings['btn_pos'] == 'right' ); ?>>
							<?php _e( 'Right', 'sticky-side-buttons' ); ?>
                        </label>
                    </div>
                </div>

                <div class="ssb-row">
                    <div class="ssb-col">
                        <label for="ssb-btn-dark">
                            <strong><?php _e( 'Rollover Style', 'sticky-side-buttons' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-btn-dark">
                            <input type="radio"
                                   name="ssb_settings[btn_hover]"
                                   id="ssb-btn-dark"
                                   value="dark"
								<?php checked( isset( $this->settings['btn_hover'] ) && $this->settings['btn_hover'] == 'dark' ); ?>>
							<?php _e( 'Darken', 'sticky-side-buttons' ); ?>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-btn-light">
                            <input type="radio"
                                   name="ssb_settings[btn_hover]"
                                   id="ssb-btn-light"
                                   value="light"
								<?php checked( isset( $this->settings['btn_hover'] ) && $this->settings['btn_hover'] == 'light' ); ?>>
							<?php _e( 'Lighten', 'sticky-side-buttons' ); ?>
                        </label>
                    </div>
                </div>

                <div class="ssb-row">
                    <div class="ssb-col">
                        <label for="ssb-btn-none">
                            <strong><?php _e( 'Animation', 'sticky-side-buttons' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-btn-none">
                            <input type="radio"
                                   name="ssb_settings[btn_anim]"
                                   id="ssb-btn-none"
                                   value="none"
								<?php checked( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'none' ); ?>>
							<?php _e( 'None', 'sticky-side-buttons' ); ?>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-btn-slide">
                            <input type="radio"
                                   name="ssb_settings[btn_anim]"
                                   id="ssb-btn-slide"
                                   value="slide"
								<?php checked( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'slide' ); ?>>
							<?php _e( 'Slide', 'sticky-side-buttons' ); ?>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-btn-icons">
                            <input type="radio"
                                   name="ssb_settings[btn_anim]"
                                   id="ssb-btn-icons"
                                   value="icons"
								<?php checked( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'icons' ); ?>>
							<?php _e( 'Icons Only', 'sticky-side-buttons' ); ?>
                        </label>
                    </div>
                </div>

                <div class="ssb-row">
                    <div class="ssb-col">
                        <label for="ssb-btn-disable">
                            <strong><?php _e( 'Enable Social Sharing', 'sticky-side-buttons' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-btn-share">
                            <input type="checkbox"
                                   name="ssb_settings[btn_share]"
                                   id="ssb-btn-share"
                                   value="1"
								<?php checked( isset( $this->settings['btn_share'] ) && $this->settings['btn_share'] == 1 ); ?>>
                        </label>
                    </div>
                </div>

                <div class="ssb-row">
                    <div class="ssb-col">
                        <label for="ssb-btn-disable">
                            <strong><?php _e( 'Disable on Mobile', 'sticky-side-buttons' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <label for="ssb-btn-disable">
                            <input type="checkbox"
                                   name="ssb_settings[btn_disable_mobile]"
                                   id="ssb-btn-disable"
                                   value="1"
								<?php checked( isset( $this->settings['btn_disable_mobile'] ) && $this->settings['btn_disable_mobile'] == 1 ); ?>>
                        </label>
                    </div>
                </div>

                <div class="ssb-row">
                    <div class="ssb-col">
                        <label for="ssb-btn-z-index">
                            <strong><?php _e( 'Z-Index', 'sticky-side-buttons' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <input type="number"
                               name="ssb_settings[btn_z_index]"
                               id="ssb-btn-z-index" class="small-text"
                               value="<?php echo esc_attr( isset( $this->settings['btn_z_index'] ) ? intval( $this->settings['btn_z_index'] ) : 1 ); ?>">

                    </div>
                </div>

                <div class="ssb-row">
                    <div class="ssb-col">
                        <label>
                            <strong><?php _e( 'Show on', 'sticky-side-buttons' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="ssb-col">
                        <p>
                            <label for="show-on-pages">
                                <input type="checkbox"
                                       name="ssb_settings[show_on_pages]"
                                       id="show-on-pages"
                                       value="1"
									<?php checked( isset( $this->settings['show_on_pages'] ) && $this->settings['show_on_pages'] == 1 ); ?>>
								<?php _e( 'Pages', 'sticky-side-buttons' ); ?>
                            </label>
                        </p>
                        <p>
                            <label for="show-on-posts">
                                <input type="checkbox"
                                       name="ssb_settings[show_on_posts]"
                                       id="show-on-posts"
                                       value="1"
									<?php checked( isset( $this->settings['show_on_posts'] ) && $this->settings['show_on_posts'] == 1 ); ?>>
								<?php _e( 'Posts', 'sticky-side-buttons' ); ?>
                            </label>
                        </p>
						<?php $this->cpts = get_post_types( array( '_builtin' => false ), 'objects' );
						if ( $this->cpts ):
							foreach ( $this->cpts as $cpt ): ?>
                                <p>
                                    <label for="show-on-<?php echo esc_attr( $cpt->name ); ?>">
                                        <input type="checkbox"
                                               name="ssb_showoncpt[]"
                                               id="show-on-<?php echo esc_attr( $cpt->name ); ?>"
                                               value="<?php echo esc_attr( $cpt->name ); ?>"
											<?php checked( $this->showoncpt && in_array( $cpt->name, $this->showoncpt ) ); ?>>
										<?php echo esc_html( $cpt->labels->name ); ?>
                                    </label>
                                </p>
							<?php endforeach; endif; ?>
                        <p>
                            <label for="show-on-frontpage">
                                <input type="checkbox"
                                       name="ssb_settings[show_on_frontpage]"
                                       id="show-on-frontpage"
                                       value="1"
									<?php checked( isset( $this->settings['show_on_frontpage'] ) && $this->settings['show_on_frontpage'] == 1 ); ?>>
								<?php _e( 'Front Page', 'sticky-side-buttons' ); ?>
                            </label>
                        </p>
                    </div>
                </div>


            </div>
            <footer class="ssb-panel-footer">
                <input type="submit" class="button-primary"
                       value="<?php _e( 'Save Settings', 'sticky-side-buttons' ); ?>">
            </footer>
        </div>
		<?php
		return true;
	}


	/**
	 * Icons UI Part
	 *
	 * @since 1.0
	 */
	public function icons() {

		// Show on
		if ( ( isset( $this->settings['show_on_pages']) && $this->settings['show_on_pages'] && get_post_type() == 'page' && ! is_front_page() ) ||
		     ( isset($this->settings['show_on_posts']) && $this->settings['show_on_posts'] && ( get_post_type() == 'post' ) ) ||
		     ( isset($this->settings['show_on_frontpage']) && $this->settings['show_on_frontpage'] && is_front_page() ) || (!empty($this->showoncpt) && in_array( get_post_type(), $this->showoncpt ) ) ) {

			// Buttons exists
			if ( isset( $this->buttons['btns'] ) ) {
				?>
                <div id="ssb-container"
                     class="<?php
				     echo ( isset( $this->settings['btn_pos'] ) && $this->settings['btn_pos'] == 'left' ) ? 'ssb-btns-left' : 'ssb-btns-right';
				     echo ( isset( $this->settings['btn_disable_mobile'] ) ) ? ' ssb-disable-on-mobile' : '';
				     echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'slide' ) ? ' ssb-anim-slide' : '';
				     echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'icons' ) ? ' ssb-anim-icons' : '';
				     ?>">
                    <ul class="<?php echo esc_attr( ( isset( $this->settings['btn_hover'] ) && $this->settings['btn_hover'] == 'light' ) ? 'ssb-light-hover' : 'ssb-dark-hover' ); ?>">
						<?php
						// Buttons loop + ordering
						foreach ( $this->btns_order AS $btn_key => $btn_id ) {
							?>
                            <li id="ssb-btn-<?php echo esc_attr( $btn_id ); ?>">
                                <p>
                                    <?php 
                                    $button_text = isset( $this->buttons['btns'][ $btn_id ]['btn_text'] ) ? $this->buttons['btns'][ $btn_id ]['btn_text'] : '';
                                    $button_icon = isset( $this->buttons['btns'][ $btn_id ]['btn_icon'] ) ? $this->buttons['btns'][ $btn_id ]['btn_icon'] : '';
                                    $button_url = $this->buttons['btns'][ $btn_id ]['btn_link'];
                                    $is_new_window = !empty($this->buttons['btns'][ $btn_id ]['open_new_window']);
                                    $show_text = isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] != 'icons';
                                    
                                    // Create accessible aria-label
                                    $aria_label = $button_text;
                                    if ( $is_new_window ) {
                                        $aria_label .= ' ' . __( '(opens in new window)', 'sticky-side-buttons' );
                                    }
                                    ?>
                                    <a href="<?php echo esc_url( $button_url ); ?>" 
                                       <?php echo $is_new_window ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
                                       aria-label="<?php echo esc_attr( $aria_label ); ?>"
                                       role="button"
                                       tabindex="0">
                                        <?php if ( $button_icon ): ?>
                                            <span class="<?php echo esc_attr( $button_icon ); ?>" aria-hidden="true"></span>
                                        <?php endif; ?>
                                        <?php if ( $show_text && $button_text ): ?>
                                            <span class="ssb-text"><?php echo esc_html( $button_text ); ?></span>
                                        <?php else: ?>
                                            <span class="ssb-sr-only"><?php echo esc_html( $button_text ? $button_text : __( 'Button', 'sticky-side-buttons' ) ); ?></span>
                                        <?php endif; ?>
                                    </a>
                                </p>
                            </li>
							<?php
						}

						// Social Icons
						if ( isset( $this->settings['btn_share'] ) ) {
							$show_share_text = isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] != 'icons';
							?>
                            <li class="ssb-share-btn">
                                <p>
                                    <a href="#" 
                                       aria-label="<?php esc_attr_e( 'Open social sharing options', 'sticky-side-buttons' ); ?>"
                                       aria-expanded="false"
                                       aria-haspopup="true"
                                       role="button"
                                       tabindex="0">
                                        <span class="fas fa-share-alt" aria-hidden="true"></span>
                                        <?php if ( $show_share_text ): ?>
                                            <span class="ssb-text"><?php esc_html_e( 'Social Share', 'sticky-side-buttons' ); ?></span>
                                        <?php else: ?>
                                            <span class="ssb-sr-only"><?php esc_html_e( 'Social Share', 'sticky-side-buttons' ); ?></span>
                                        <?php endif; ?>
                                    </a>
                                </p>
                                <div class="ssb-social-popup" role="menu" aria-label="<?php esc_attr_e( 'Social sharing options', 'sticky-side-buttons' ); ?>">
                                    <a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() ) ); ?>"
                                       onclick="window.open(this.href, 'facebook', 'left=60,top=40,width=500,height=500,toolbar=1,resizable=0'); return false;" 
                                       rel="noopener noreferrer" 
                                       target="_blank"
                                       role="menuitem"
                                       aria-label="<?php esc_attr_e( 'Share on Facebook (opens in new window)', 'sticky-side-buttons' ); ?>">
                                        <span class="fab fa-facebook-f" aria-hidden="true"></span> 
                                        <span><?php esc_html_e( 'Facebook', 'sticky-side-buttons' ); ?></span>
                                    </a>
                                    <a href="<?php echo esc_url( 'https://twitter.com/home?status=' . urlencode( get_permalink() ) ); ?>"
                                       onclick="window.open(this.href, 'twitter', 'left=60,top=40,width=500,height=500,toolbar=1,resizable=0'); return false;" 
                                       rel="noopener noreferrer" 
                                       target="_blank"
                                       role="menuitem"
                                       aria-label="<?php esc_attr_e( 'Share on Twitter (opens in new window)', 'sticky-side-buttons' ); ?>">
                                        <span class="fab fa-twitter" aria-hidden="true"></span> 
                                        <span><?php esc_html_e( 'Twitter', 'sticky-side-buttons' ); ?></span>
                                    </a>
                                </div>
                            </li>
							<?php
						}
						?>
                    </ul>
                </div>
				<?php
			}
		}

	}

}
