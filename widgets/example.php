<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit(); // Exit if accessed directly
}

class MYEW_Example_Widget extends Widget_Base {

    public function get_name() {
        return 'myew-example-widget-id';
    }

    public function get_title() {
        return esc_html__('Example Widget', 'my-elementor-widget');
    }

    public function get_script_depends() {
        return ['myew-script'];
    }

    public function get_icon() {
        return ''; // Add the icon class here if any
    }

    public function get_categories() {
        return ['myew-for-elementor'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content Settings', 'my-elementor-widget'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'ai' => [
					'type' => 'text',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title motherfucker', 'elementor' ),
				'default' => esc_html__( 'bla bla bla', 'elementor' ),
			]
		);

        // Add controls here

        $this->end_controls_section();

        $this->style_tab();
    }

    private function style_tab() {
        // Add style tab controls here
    }

    protected function render() {
        $mywe_values = $this->get_settings_for_display();
        $this->add_inline_editing_attributes( 'title' );
        ?>
        <div>
            <h1><?php echo $mywe_values['title']?></h1>
        </div>
        <?php
    }

    protected function content_template() {
        // Add JS template here if needed
    }
}

Plugin::instance()->widgets_manager->register(new MYEW_Example_Widget());
