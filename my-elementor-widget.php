<?php
/**
 * Plugin Name: My Elementor Widget
 * Plugin URI: https://example.com
 * Description: A custom Elementor widget
 * Version: 1.0.0
 * Author: Louis Castel
 * Author URI: https://quoicoubeh.ninja
 * Text Domain: my-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit(); // Exit if accessed directly
}

final class My_Elementor_Widget {

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->define_constants();
        add_action('init', [$this, 'i18n']);
        add_action('wp_enqueue_scripts', [$this, 'scripts_styles']);
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
    }

    public function define_constants() {
        define('MYEW_PLUGIN_URL', trailingslashit(plugin_dir_url(__FILE__)));
        define('MYEW_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
    }

    public function i18n() {
        load_plugin_textdomain('my-elementor-widget', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function scripts_styles() {
        wp_register_style('myew-style', MYEW_PLUGIN_URL . 'assets/dist/css/public.min.css', [], rand(), 'all');
        wp_register_script('myew-script', MYEW_PLUGIN_URL . 'assets/dist/js/public.min.js', ['jquery'], rand(), true);

        wp_enqueue_style('myew-style');
        wp_enqueue_script('myew-script');
    }

    public function on_plugins_loaded() {
        if (did_action('elementor/loaded')) {
            add_action('elementor/init', [$this, 'init']);
        }
    }

    public function init() {
        // initialise les widgets du plugin ici
        add_action('elementor/widgets/register', [$this, 'init_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'init_category']);
    }

    public function init_widgets() {
        require_once MYEW_PLUGIN_PATH . 'widgets/example.php';
    }

    public function init_category($elements_manager) {
        $elements_manager->add_category('myew-for-elementor', [
            'title' => 'My Elementor Widgets'
        ], 1);
    }
}

My_Elementor_Widget::instance();
