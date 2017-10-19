<?php
/**
 * Handles plugin options
 **/
if ( ! class_exists( 'UCF_Acad_Cal_Config' ) ) {
	class UCF_Acad_Cal_Config {
		public static
			$option_prefix    = 'ucf_acad_cal_',
			$options_defaults = array(
				'calendar_feed'    => 'http://calendar.ucf.edu/feed/upcoming/',
				'calendar_url'     => 'http://calendar.ucf.edu/',
				'default_count'    => 7,
				'default_layout'   => 'classic',
				'cache_items'      => true,
				'cache_expiration' => 3 // hours
			);

		/**
		 * Returns an array of registered layouts
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return array The array of registered layouts
		 **/
		public static function get_layouts() {
			$layouts = array(
				'classic' => 'Classic Layout'
			);

			$layouts = apply_filters( self::$option_prefix . 'get_layouts', $layouts );

			return $layouts;
		}

		/**
		 * Creates options via the WP Options API that are utilized by the
		 * plugin. Intended to be run on plugin activation.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function add_options() {
			$defaults = self::$options_defaults;

			add_option( self::$option_prefix . 'calendar_feed', $defaults['calendar_feed'] );
			add_option( self::$option_prefix . 'calendar_url', $defaults['calendar_url'] );
			add_option( self::$option_prefix . 'default_count', $defaults['default_count'] );
			add_option( self::$option_prefix . 'default_layout', $defaults['default_layout'] );
			add_option( self::$option_prefix . 'cache_items', $defaults['cache_items'] );
			add_option( self::$option_prefix . 'cache_expiration', $defaults['cache_expiration'] );
		}

		/**
		 * Deletes options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin uninstallation.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function delete_options() {
			delete_option( self::$option_prefix . 'calendar_feed' );
			delete_option( self::$option_prefix . 'calendar_url' );
			delete_option( self::$option_prefix . 'default_count' );
			delete_option( self::$option_prefix . 'default_layout' );
			delete_option( self::$option_prefix . 'cache_items' );
			delete_option( self::$option_prefix . 'cache_expiration' );
		}

		/**
		 * Returns a list of default plugin options. Applies any overridden
		 * default values set within the option page.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return array
		 **/
		public static function get_option_defaults() {
			$defaults = self::$options_defaults;

			$configurable_defaults = array(
				'calendar_feed'    => get_option( self::$option_prefix . 'calendar_feed' ),
				'calendar_url'     => get_option( self::$option_prefix . 'calendar_url' ),
				'default_count'    => get_option( self::$option_prefix . 'default_count' ),
				'default_layout'   => get_option( self::$option_prefix . 'default_layout' ),
				'cache_items'      => get_option( self::$option_prefix . 'cache_items' ),
				'cache_expiration' => get_option( self::$option_prefix . 'cache_expiration' )
			);

			$configurable_defaults = self::format_options( $configurable_defaults );

			$defaults = array_merge( $defaults, $configurable_defaults );

			return $defaults;
		}

		/**
		 * Returns a list of default shortcode attributes.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return array The shortcode attributes
		 **/
		public static function get_shortcode_defaults() {
			$defaults = self::get_option_defaults();

			return array(
				'calendar_feed' => $defaults['calendar_feed'],
				'calendar_url'  => $defaults['calendar_url'],
				'count'         => $defaults['default_count'],
				'layout'        => $defaults['defaults_layout']
			);
		}

		/**
		 * Returns an array with plugin defaults applied.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $list The list to which defaults will be applied
		 * @param boolean $list_keys_only Modifies results to only return array key values present in $list
		 * @return array
		 **/
		 public static function apply_option_defaults( $list, $list_keys_only=False ) {
			$defaults = self::get_option_defaults();
			$options = array();

			if ( $list_keys_only ) {
				foreach( $list as $key => $val ) {
					$options[$key] = ! empty( $val ) ? $val : $defaults[$key];
				}
			} else {
				$options = array_merge( $defaults, $list );
			}

			$options = self::format_options( $options );

			return $options;
		}

		/**
		 * Performs typecasting and sanitization on an array of plugin options
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $list The array of options to format
		 * @return array The formatted options array
		 **/
		 public static function format_options( $list ) {
			foreach( $list as $key => $val ) {
				switch( $key ) {
					case 'cache_items':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
						break;
					case 'default_count':
					case 'cache_expiration':
						$list[$key] = intval( $val );
						break;
					default:
						break;
				}
			}

			return $list;
		}

		/**
		 * Convenience method for returning an option from the WP Options API
		 * or a plugin option default.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param string $option_name The option name
		 * @return mixed The value of the option
		 **/
		 public static function get_option_or_default( $option_name ) {
			$option_name_no_prefix = str_replace( self::$option_prefix, '', $option_name );
			$option_name = self::$option_prefix . $option_name_no_prefix;

			$option = get_option( $option_name );

			$option_formatted = self::apply_option_defaults( array(
				$option_name_no_prefix => $option
			), true );

			return $option_formatted[$option_name_no_prefix];
		}

		/**
		 * Initializes setting registration with the Settings API
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function settings_init() {
			add_settings_section(
				'ucf_acad_cal_general',
				'General',
				null,
				'ucf_acad_cal'
			);

			add_settings_section(
				'ucf_acad_cal_display',
				'Display Settings',
				null,
				'ucf_acad_cal'
			);

			add_settings_section(
				'ucf_acad_cal_cache',
				'Feed Caching',
				null,
				'ucf_acad_cal'
			);

			/**
			 * General Settings
			 **/
			register_setting(
				'ucf_acad_cal',
				self::$option_prefix . 'calendar_feed'
			);

			add_settings_field(
				self::$option_prefix . 'calendar_feed',
				'Calendar Feed',
				array( 'UCF_Acad_Cal_Config', 'display_settings_field' ),
				'ucf_acad_cal',
				'ucf_acad_cal_general',
				array(
					'label_for'   => self::$option_prefix . 'calendar_feed',
					'description' => 'The url of the academic calendar feed.',
					'type'        => 'text'
				)
			);

			register_setting(
				'ucf_acad_cal',
				self::$option_prefix . 'calendar_url'
			);

			add_settings_field(
				self::$option_prefix . 'calendar_url',
				'Calendar URL',
				array( 'UCF_Acad_Cal_Config', 'display_settings_field' ),
				'ucf_acad_cal',
				'ucf_acad_cal_general',
				array(
					'label_for'   => self::$option_prefix . 'calendar_url',
					'description' => 'The url of the academic calendar (i.e. when a user clicks to see more academic calendar dates).',
					'type'        => 'text'
				)
			);

			/**
			 * Display Settings
			 **/
			register_setting(
				'ucf_acad_cal',
				self::$option_prefix . 'default_count'
			);

			add_settings_field(
				self::$option_prefix . 'default_count',
				'Default Item Count',
				array( 'UCF_Acad_Cal_Config', 'display_settings_field' ),
				'ucf_acad_cal',
				'ucf_acad_cal_display',
				array(
					'label_for'   => self::$option_prefix . 'default_count',
					'description' => 'The number of items to display (by default).',
					'type'        => 'number'
				)
			);

			register_setting(
				'ucf_acad_cal',
				self::$option_prefix . 'default_layout'
			);

			$layouts = self::get_layouts();

			add_settings_field(
				self::$option_prefix . 'default_layout',
				'Default Layout',
				array( 'UCF_Acad_Cal_Config', 'display_settings_field' ),
				'ucf_acad_cal',
				'ucf_acad_cal_display',
				array(
					'label_for'   => self::$option_prefix . 'default_layout',
					'description' => 'The default layout to use when displaying academic calendar items.',
					'type'        => 'select',
					'options'     => $layouts
				)
			);

			/**
			 * Cache Settings
			 **/
			register_setting(
				'ucf_acad_cal',
				self::$option_prefix . 'cache_items'
			);

			add_settings_field(
				self::$option_prefix . 'cache_items',
				'Cache Feed Items',
				array( 'UCF_Acad_Cal_Config', 'display_settings_field' ),
				'ucf_acad_cal',
				'ucf_acad_cal_cache',
				array(
					'label_for'   => self::$option_prefix . 'cache_items',
					'description' => 'When checked, academic calendar feed items will be cached for the amount of time configured below.',
					'type'        => 'checkbox'
				)
			);

			register_setting(
				'ucf_acad_cal',
				self::$option_prefix . 'cache_expiration'
			);

			add_settings_field(
				self::$option_prefix . 'cache_expiration',
				'Cache Expiration (In Hours)',
				array( 'UCF_Acad_Cal_Config', 'display_settings_field' ),
				'ucf_acad_cal',
				'ucf_acad_cal_cache',
				array(
					'label_for'   => self::$option_prefix . 'cache_expiration',
					'description' => 'The length of time (in hours) academic calendar items should be cached.',
					'type'        => 'number'
				)
			);
		}

		/**
		 * Display an individual setting's field markup
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $args An array of field arguments
		 * @return string The formatted html of the field
		 **/
		 public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$options       = isset( $args['options'] ) ? $args['options'] : null;
			$current_value = self::get_option_or_default( $option_name );
			$markup        = '';

			switch( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo ( $current_value == true ) ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					break;
				case 'number':
					ob_start();
				?>
					<input type="number" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'select':
					ob_start();
				?>
					<select id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>">
					<?php foreach( $options as $key => $val ) : ?>
						<option value="<?php echo $key; ?>"<?php echo ( $current_value === $key ) ? ' selected' : ''; ?>><?php echo $val; ?></option>
					<?php endforeach; ?>
					</select>
				<?php
					$markup = ob_get_clean();
					break;
				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}

			echo $markup;
		}

		/**
		 * Registers the settings page to display in the WordPress admin
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return string The resulting page's hook_suffix
		 **/
		 public static function add_options_page() {
			$page_title = 'UCF Academic Calendar Settings';
			$menu_title = 'UCF Academic Calendar';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_acad_cal';
			$callback   = array( 'UCF_Acad_Cal_Config', 'options_page_html' );

			return add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);
		}

		/**
		 * Displays the plugin's settings page form
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		 public static function options_page_html() {
			ob_start();
		?>
			<div class="wrap">
				<h1><?php echo get_admin_page_title(); ?></h1>
				<form method="post" action="options.php">
				<?php
					settings_fields( 'ucf_acad_cal' );
					do_settings_sections( 'ucf_acad_cal' );
					submit_button();
				?>
				</form>
			</div>
		<?php
			echo ob_get_clean();
		}
	}
}
