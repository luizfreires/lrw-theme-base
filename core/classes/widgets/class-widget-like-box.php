<?php
/**
 * Odin_Widget_Like_Box class.
 *
 * Facebook like widget.
 *
 * @package  Odin
 * @category Widget
 * @author   WPBrasil
 * @version  2.2.0
 */
class Odin_Widget_Like_Box extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_facebook_like_box',
			__( 'Odin - Facebook Like Box', 'odin' ),
			array( 'description' => __( 'This widget includes a facebook like box on your blog', 'odin' ), )
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param  array $instance Previously saved values from database.
	 *
	 * @return string          Widget options form.
	 */
	public function form( $instance ) {
		$title         = isset( $instance['title'] ) ? $instance['title'] : '';
		$url           = isset( $instance['url'] ) ? $instance['url'] : '';
		$width         = isset( $instance['width'] ) ? $instance['width'] : 300;
		$height        = isset( $instance['height'] ) ? $instance['height'] : '';
		$small_header  = isset( $instance['small_header'] ) ? $instance['small_header'] : 'true';
		$adapt_width   = isset( $instance['adapt_width'] ) ? $instance['adapt_width'] : 'false';
		$hide_cover    = isset( $instance['hide_cover'] ) ? $instance['hide_cover'] : 'false';
		$friends_faces = isset( $instance['friends_faces'] ) ? $instance['friends_faces'] : 'true';
		$show_posts    = isset( $instance['show_posts'] ) ? $instance['show_posts'] : 'false';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>">
				<?php _e( 'Facebook Page URL:', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>">
				<?php _e( 'Width:', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'width' ); ?>" size="5" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo intval( $width ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>">
				<?php _e( 'Height:', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'height' ); ?>" size="5" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo intval( $height ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'small_header' ); ?>">
				<?php _e( 'Small Header:', 'odin' ); ?>
				<select id="<?php echo $this->get_field_id( 'small_header' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'small_header' ); ?>">
					<option value="true" <?php selected( 'true', $small_header, true ); ?>><?php _e( 'True', 'odin' ); ?></option>
					<option value="false" <?php selected( 'false', $small_header, true ); ?>><?php _e( 'False', 'odin' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'adapt_width' ); ?>">
				<?php _e( 'Adaptive width:', 'odin' ); ?>
				<select id="<?php echo $this->get_field_id( 'adapt_width' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'adapt_width' ); ?>">
					<option value="true" <?php selected( 'true', $adapt_width, true ); ?>><?php _e( 'True', 'odin' ); ?></option>
					<option value="false" <?php selected( 'false', $adapt_width, true ); ?>><?php _e( 'False', 'odin' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'friends_faces' ); ?>">
				<?php _e( 'Show Friends Faces:', 'odin' ); ?>
				<select id="<?php echo $this->get_field_id( 'friends_faces' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'friends_faces' ); ?>">
					<option value="true" <?php selected( 'true', $friends_faces, true ); ?>><?php _e( 'True', 'odin' ); ?></option>
					<option value="false" <?php selected( 'false', $friends_faces, true ); ?>><?php _e( 'False', 'odin' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_cover' ); ?>">
				<?php _e( 'Hide Cover Photo:', 'odin' ); ?>
				<select id="<?php echo $this->get_field_id( 'hide_cover' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'hide_cover' ); ?>">
					<option value="true" <?php selected( 'true', $hide_cover, true ); ?>><?php _e( 'True', 'odin' ); ?></option>
					<option value="false" <?php selected( 'false', $hide_cover, true ); ?>><?php _e( 'False', 'odin' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_posts' ); ?>">
				<?php _e( 'Show Posts:', 'odin' ); ?>
				<select id="<?php echo $this->get_field_id( 'show_posts' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'show_posts' ); ?>">
					<option value="true" <?php selected( 'true', $show_posts, true ); ?>><?php _e( 'True', 'odin' ); ?></option>
					<option value="false" <?php selected( 'false', $show_posts, true ); ?>><?php _e( 'False', 'odin' ); ?></option>
				</select>
			</label>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param  array $new_instance Values just sent to be saved.
	 * @param  array $old_instance Previously saved values from database.
	 *
	 * @return array               Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['url']           = ( ! empty( $new_instance['url'] ) ) ? esc_url( $new_instance['url'] ) : '';
		$instance['width']         = ( ! empty( $new_instance['width'] ) ) ? intval( $new_instance['width'] ) : 300;
		$instance['height']        = ( ! empty( $new_instance['height'] ) ) ? intval( $new_instance['height'] ) : '';
		$instance['small_header']  = ( ! empty( $new_instance['small_header'] ) ) ? sanitize_text_field( $new_instance['small_header'] ) : 'true';
		$instance['adapt_width']   = ( ! empty( $new_instance['adapt_width'] ) ) ? sanitize_text_field( $new_instance['adapt_width'] ) : 'false';
		$instance['hide_cover']    = ( ! empty( $new_instance['hide_cover'] ) ) ? sanitize_text_field( $new_instance['hide_cover'] ) : 'false';
		$instance['friends_faces'] = ( ! empty( $new_instance['friends_faces'] ) ) ? sanitize_text_field( $new_instance['friends_faces'] ) : 'true';
		$instance['show_posts']    = ( ! empty( $new_instance['show_posts'] ) ) ? sanitize_text_field( $new_instance['show_posts'] ) : 'false';

		return $instance;
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @param  array  $args      Widget arguments.
	 * @param  array  $instance  Widget options.
	 *
	 * @return string            Facebook like box.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo sprintf(
			'<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/' . get_locale() . '/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, "script", "facebook-jssdk"));</script>
			<div class="fb-page" data-href="%1$s" data-width="%2$s" data-height="%3$s" data-small-header="%4$s" data-adapt-container-width="%5$s" data-hide-cover="%6$s" data-show-facepile="%7$s" data-show-posts="%8$s"></div>',
			$instance['url'],
			$instance['width'],
			$instance['height'],
			$instance['small_header'],
			$instance['adapt_width'],
			$instance['hide_cover'],
			$instance['friends_faces'],
			$instance['show_posts']
		);

		echo $args['after_widget'];
	}
}

/**
 * Register the Like Box Widget.
 */
function odin_like_box_widget() {
	register_widget( 'Odin_Widget_Like_Box' );
}

add_action( 'widgets_init', 'odin_like_box_widget' );
