<?php
/**
 * Odin_Widget_Embed class.
 *
 * Embed widget.
 *
 * @package  Odin
 * @category Widget
 */
class Odin_Widget_Embed extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_embed', // Base ID
			__( 'Odin - Embed Vídeo', 'odin' ), // Name
			array(
			'description' => __( 'Display a video.', 'odin' ),
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
		$title 			= apply_filters( 'widget_title', $instance['title'] );
		$embed 			= $instance['embed'];
		$height			= $instance['height'];
		$desc 			= $instance['desc'];
		$show_url 		= $instance['show_url'];
		$url 			= $instance['url'];
		$text_channel 	= $instance['text_channel'];

		// Start
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

        echo '<p>' . wp_oembed_get( $embed, array( 'width' => 'full', 'height' => $height ) ) . '</p>';

		echo ( ! empty( $desc ) ) ? '<p class="entry-caption"><em>' . $desc . '</em></p>' : '';

		if ( ( $show_url == 1 ) && ( ! empty( $url ) ) ) :

			echo '<p><a href="' . $url . '" title="' . ( ( ! empty( $text_channel ) ) ? $text_channel : __( 'Visit our videos', 'odin' ) ) . '" target="_blank">' . ( ( ! empty( $text_channel ) ) ? $text_channel : __( 'Visit our videos', 'odin' ) ) .  '</a></p>';

		endif;

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
		$instance['title']			= ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['embed']			= ( ! empty( $new_instance['embed'] ) ) ? sanitize_text_field( $new_instance['embed'] ) : '';
		$instance['height']         = ( ! empty( $new_instance['height'] ) ) ? intval( $new_instance['height'] ) : 250;
		$instance['desc']			= ( ! empty( $new_instance['desc'] ) ) ? sanitize_text_field( $new_instance['desc'] ) : '';
		$instance['show_url']		= ( ! empty( $new_instance['show_url'] ) ) ? intval( $new_instance['show_url'] ) : 0;
		$instance['url']           	= ( ! empty( $new_instance['url'] ) ) ? esc_url( $new_instance['url'] ) : '';
		$instance['text_channel']	= ( ! empty( $new_instance['text_channel'] ) ) ? sanitize_text_field( $new_instance['text_channel'] ) : '';

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

		$title			= isset( $instance['title'] ) ? $instance['title'] : '';
		$embed			= isset( $instance['embed'] ) ? $instance['embed'] : '';
		$height         = isset( $instance['height'] ) ? $instance['height'] : 250;
        $desc			= isset( $instance['desc'] ) ? $instance['desc'] : '';
        $show_url		= isset( $instance['show_url'] ) ? $instance['show_url'] : '1';
        $url			= isset( $instance['url'] ) ? $instance['url'] : '';
        $text_channel	= isset( $instance['text_channel'] ) ? $instance['text_channel'] : '';

        ?>

        <p>
        	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'embed' ); ?>"><?php _e( 'Embed:', 'odin' ) ?></label>
			<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id( 'embed' ); ?>" name="<?php echo $this->get_field_name( 'embed' ); ?>"><?php echo $instance['embed']; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e( 'Description:', 'odin' ) ?></label>
			<textarea class="widefat" rows="2" cols="20" id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>"><?php echo $instance['desc']; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_url' ); ?>">
				<input id="<?php echo $this->get_field_id( 'show_url' ); ?>" name="<?php echo $this->get_field_name( 'show_url' ); ?>" type="checkbox" value="1" <?php checked( 1, $show_url, true ); ?> /> <?php _e( 'Show link to channel?', 'odin' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Link channel:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text_channel' ); ?>"><?php _e( 'Text for link channel:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'text_channel' ); ?>" name="<?php echo $this->get_field_name( 'text_channel' ); ?>" value="<?php echo $instance['text_channel']; ?>" />
		</p>

        <?php

	}

}

/**
 * Register Widget.
 *
 * @return void
 */
function odin_widget_embed_register() {
	register_widget( 'Odin_Widget_Embed' );
}

add_action( 'widgets_init', 'odin_widget_embed_register' );
