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
		$form_id = $instance['form_id'];

		// Start
		echo $args['before_widget'];

		if ( ! empty( $form_id ) ) {
			echo do_shortcode( '[contact-form-7 id="' . $form_id . '"]' );
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

		$form_id 	= isset( $instance['form_id'] ) ? $instance['form_id'] : '';

		if( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			echo __( 'Sorry, this widget requires plugin <a href="http://wordpress.org/extend/plugins/contact-form-7/" target="_blank">Contact Form 7</a> installed and activated. Please install/activate the plugin before using this widget', 'odin' );

			return false;
		}

		$post_type = 'wpcf7_contact_form';

		$args = array (
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);

		$contact_forms = get_posts( $args );

        if ( empty( $contact_forms ) ) {
			echo __( 'You do not have any setup contact form. Please create a contact form before using this widget.', 'odin' );
			echo '<br/>';
			echo '<a href="' . admin_url() . '?page=wpcf7" title="' . __( 'Click here to setup', 'odin' ) . '">' . __( 'Contact Form 7 settings', 'odin' ) . '</a>';

			return false;
		}

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'form_id' ); ?>"><?php _e( 'Escolha aqui:', 'odin' ) ?></label>
			<?php
				$cf7posts = new WP_Query( array( 'post_type' => 'wpcf7_contact_form' ) );
				if ( $cf7posts->have_posts() ) :
			?>
			<select class="widefat" name="<?php echo $this->get_field_name( 'form_id' ); ?>" id="<?php echo $this->get_field_id( 'form_id' ); ?>">
				<?php while( $cf7posts->have_posts() ) : $cf7posts->the_post(); ?>
					<option value="<?php the_id(); ?>"<?php selected( get_the_id(), $this->get_field_id( 'form_id' ) ); ?>><?php the_title(); ?></option>
				<?php endwhile; endif; ?>
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