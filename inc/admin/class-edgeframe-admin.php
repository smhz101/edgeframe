<?php
/**
 * Admin class.
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class EdgeFrame_Admin
 */
class EdgeFrame_Admin {
	/**
	 * Singleton instance.
	 *
	 * @var EdgeFrame_Admin|null
	 */
	private static $instance = null;

	/** @var string The hook suffix for the settings page. */
	public $hook_suffix = '';

	/**
	 * Get the singleton instance.
	 *
	 * @return EdgeFrame_Admin
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'maybe_enqueue' ) );
	}

	/**
	 * Add the settings page to the admin menu.
	 */
	public function add_menu() {
		$this->hook_suffix = add_theme_page(
			__( 'EdgeFrame Settings', 'edgeframe' ),
			__( 'EdgeFrame', 'edgeframe' ),
			'manage_options',
			'edgeframe-settings',
			'edgeframe_render_settings_page'
		);
	}

	/**
	 * Enqueue admin scripts/styles only on our settings page.
	 *
	 * @param string $hook The current admin page.
	 */
	public function maybe_enqueue( $hook ) {
		if ( $hook !== $this->hook_suffix ) {
			return; }

		// Base styles for sleek UI
		wp_enqueue_style(
			'edgeframe-admin',
			EDGEFRAME_URI . 'assets/css/admin.css',
			array(),
			EDGEFRAME_VERSION
		);

		wp_enqueue_script(
			'edgeframe-admin',
			EDGEFRAME_URI . 'assets/js/admin.js',
			array( 'jquery' ),
			EDGEFRAME_VERSION,
			true
		);

		// Pass schema keys for JS (tabs/anchors)
		wp_localize_script(
			'edgeframe-admin',
			'EFAdmin',
			array(
				'tabs' => array_keys( edgeframe_get_settings_schema() ),
				'i18n' => array(
					'selectImage' => __( 'Select Image', 'edgeframe' ),
				),
			)
		);

		/**
		 * Allow child themes to enqueue their own assets on the settings screen.
		 * Example:
		 *   add_action('edgeframe/admin/enqueue', function($hook){ ... });
		 */
		do_action( 'edgeframe/admin/enqueue', $hook );
	}
}

// Initialize the admin class.
EdgeFrame_Admin::instance();
