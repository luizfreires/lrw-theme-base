<?php
/**
 * Odin_Widget_Contact class.
 *
 * Contact Form 7 widget.
 *
 * @package  Odin
 * @category Widget
 */
class Odin_Widget_Contact extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_contact', // Base ID
			__( 'Odin - Contact form', 'odin' ), // Name
			array(
			'description' => __( 'Display a contact form.', 'odin' ),
			) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		// extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$form_id = $instance['form_id'];

		// Start
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( ! empty( $form_id ) ) {
			echo do_shortcode( '[contact-form-7 id="' . $form_id . '"]' );

		} elseif ( ! defined( 'WPCF7_PLUGIN_NAME' ) ) {
			echo '<p>' . __( 'Sorry, this widget requires plugin <a href="http://wordpress.org/extend/plugins/contact-form-7/" target="_blank">Contact Form 7</a> installed and activated. Please install/activate the plugin before using this widget', 'odin' ) . '</p>';

		} else {
			echo '<p>' . __( 'You do not have any setup contact form. Please create a contact form before using this widget.', 'odin' ) . '</p>';
			echo '<p><a href="' . admin_url() . '?page=wpcf7" title="' . __( 'Click here to setup', 'odin' ) . '">' . __( 'Contact Form 7 settings', 'odin' ) . '</a></p>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['form_id'] = ( ! empty( $new_instance['form_id'] ) ) ? sanitize_text_field( $new_instance['form_id'] ) : '';

		return $instance;

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title      = isset( $instance['title'] ) ? $instance['title'] : '';
		$form_id 	= isset( $instance['form_id'] ) ? $instance['form_id'] : '';

		if ( ! defined( 'WPCF7_PLUGIN_NAME' ) ) {
			echo '<p>' . __( 'Sorry, this widget requires plugin <a href="http://wordpress.org/extend/plugins/contact-form-7/" target="_blank">Contact Form 7</a> installed and activated. Please install/activate the plugin before using this widget', 'odin' ) . '</p>';

			return false;
		}

		$args = array (
			'post_type' => 'wpcf7_contact_form',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);
		$contact_forms = get_posts( $args );

        if ( empty( $contact_forms ) ) {
			echo '<p>' . __( 'You do not have any setup contact form. Please create a contact form before using this widget. ', 'odin' ) . '<a href="' . admin_url() . '?page=wpcf7" title="' . __( 'Click here to setup', 'odin' ) . '">' . __( 'Contact Form 7 settings', 'odin' ) . '</a></p>';

			return false;
		}

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'form_id' ); ?>"><?php _e( 'Select a form:', 'odin' ) ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'form_id' ); ?>" id="<?php echo $this->get_field_id( 'form_id' ); ?>">
				<?php foreach ( $contact_forms as $post ) : ?>
					<option value="<?php echo $post->ID; ?>"<?php selected( $post->ID, $instance['form_id'], true ); ?>><?php echo $post->post_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<?php
	}

}

/**
 * Register Widget.
 *
 * @return void
 */
function odin_widget_contact_register() {
	register_widget( 'Odin_Widget_Contact' );
}

add_action( 'widgets_init', 'odin_widget_contact_register' );
