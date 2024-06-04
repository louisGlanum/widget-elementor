<?php
class Elementor_Widget_Test_2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'hello_world_widget_1';
	}

	public function get_title() {
		return esc_html__( 'Hello World 1', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'dan' ];
	}

	public function get_keywords() {
		return [ 'hello', 'world' ];
	}

	protected function render() {
		?>
		<p> Hello World </p>
		<?php
	}

	protected function content_template() {
		?>
		<p> Hello World </p>
		<?php
	}
}