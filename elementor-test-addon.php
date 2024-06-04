<?php
/**
 * Plugin Name: Elementor Test Addon loulou
 * Description: Custom Elementor addon.
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://developers.elementor.com/
 * Text Domain: elementor-test-addon
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.21.0
 * Elementor Pro tested up to: 3.21.0
 */

final class Plugin {
    const MINIMUM_ELEMENTOR_VERSION = '3.21.0';
    const MINIMUM_PHP_VERSION = '7.4';
	private static $_instance = null;

	public static function instance() {
        if( is_null( self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

	public function __construct() {
        if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
    }
    public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-addon' ),
			'<strong>' . esc_html__( 'Elementor Test Addon', 'elementor-test-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-addon' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
    public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-addon' ),
			'<strong>' . esc_html__( 'Elementor Test Addon', 'elementor-test-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-addon' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-addon' ),
			'<strong>' . esc_html__( 'Elementor Test Addon', 'elementor-test-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-test-addon' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	public function is_compatible() {
        	// Check if Elementor is installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}
		return true;
    }
	public function frontend_styles() {

		// wp_register_style( 'frontend-style-1', plugins_url( 'assets/css/frontend-style-1.css', __FILE__ ) );
		// wp_register_style( 'frontend-style-2', plugins_url( 'assets/css/frontend-style-2.css', __FILE__ ), [ 'external-framework' ] );
		// wp_register_style( 'external-framework', plugins_url( 'assets/css/libs/external-framework.css', __FILE__ ) );

		// wp_enqueue_style( 'frontend-style-1' );
		// wp_enqueue_style( 'frontend-style-2' );

	}
    public function frontend_scripts() {

		// wp_register_script( 'frontend-script-1', plugins_url( 'assets/js/frontend-script-1.js', __FILE__ ) );
		// wp_register_script( 'frontend-script-2', plugins_url( 'assets/js/frontend-script-2.js', __FILE__ ), [ 'external-library' ] );
		// wp_register_script( 'external-library', plugins_url( 'assets/js/libs/external-library.js', __FILE__ ) );

		// wp_enqueue_script( 'frontend-script-1' );
		// wp_enqueue_script( 'frontend-script-2' );

	}

    public function init_widgets($widgets_manager){
        // require_once( __DIR__ . '/includes/widgets-manager.php' );
        // require_once( __DIR__ . '/includes/controls-manager.php' );

        require_once(__DIR__ . '/includes/widgets/widget-text.php');
        require_once(__DIR__ . '/includes/widgets/widget-text-2.php');

        $widgets_manager->register( new \Elementor_Widget_Test() );
        $widgets_manager->register( new \Elementor_Widget_Test_2() );
    }

    public function init_category($elements_manager){
        $elements_manager->add_category(
            'loulou',
            [
                'title' => esc_html__( 'Le quartier à louis', 'textdomain' ),
                'icon' => 'fa fa-plug',
            ]
        );
        $elements_manager->add_category(
            'dan',
            [
                'title' => esc_html__( 'Les tests claqués de dan', 'textdomain' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }
	public function init() {
        add_action('elementor/widgets/register', [$this, 'init_widgets'] );
        add_action('elementor/elements/categories_registered', [$this, 'init_category']);
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'frontend_scripts' ] );
    }
}

\Plugin::instance();