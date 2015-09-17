<?php
/**
 * Odin_Widget_Social class.
 *
 * Social widget.
 *
 * @package  Odin
 * @category Widget
 */
class Odin_Widget_Social extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_social',
			__( 'Odin - Social', 'odin' ),
			array(
				'description' => __( 'Links to your social networks.', 'odin' ),
			)
		);

		$default_services = array(
			'twitter' 		=> __( 'Twitter', 'odin' ),
			'facebook' 		=> __( 'Facebook', 'odin' ),
			'google-plus' 	=> __( 'Google Plus', 'odin' ),
			'instagram' 	=> __( 'Instagram', 'odin' ),
			'linkedin' 		=> __( 'LinkedIn', 'odin' ),
			'flickr' 		=> __( 'Flickr', 'odin' ),
			'pinterest' 	=> __( 'Pinterest', 'odin' ),
			'tumblr' 		=> __( 'Tumblr', 'odin' ),
			'skype' 		=> __( 'Skype', 'odin' ),
			'vine' 			=> __( 'Vine', 'odin' ),
			'windows' 		=> __( 'Windows', 'odin' ),
			'yahoo' 		=> __( 'Yahoo', 'odin' ),
			'youtube' 		=> __( 'YouTube', 'odin' ),
			'vimeo' 		=> __( 'Vimeo', 'odin' ),
			'soundcloud'	=> __( 'SoundCloud', 'odin' ),
			'wordpress' 	=> __( 'WordPress', 'odin' ),
			'github' 		=> __( 'Github', 'odin' ),
			'dribbble' 		=> __( 'Dribbble', 'odin' ),
			'hacker-news'	=> __( 'Hacker News', 'odin' ),
			'dropbox' 		=> __( 'Dropbox', 'odin' ),
			'rss' 			=> __( 'RSS', 'odin' )
		);

		$this->services = apply_filters( 'odin-social-services', $default_services );
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

		$links 	= array();
		foreach( $this->services as $id=>$name ) {
			$links[$id] = esc_url( $instance[$id] );
		}

		$links = array_filter( $links );
		if ( empty( $links ) ) {
			return false;
		}

		// Start
		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<ul class="list-inline">';

		foreach( $links as $name=>$link ) :

			$icontitle 	= $this->services[$name];
			$iconlower	= strtolower( $this->services[$name] );
			$iconfont 	= preg_replace( '/\s+/', '-', $iconlower );

			echo '<li class="btn btn-lg"><a href="' . $link . '" title="' . $icontitle . '"><i class="fa fa-' . $iconfont . '"></i></a></li>';
		endforeach;

		echo '</ul>';
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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		foreach( $this->services as $id=>$name ) {
			$instance[$id] = !empty( $new_instance[$id] ) ? esc_url( $new_instance[$id] ) : null;
		}

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

		$defaults = array_fill_keys( array_merge( array_keys( $this->services ), array( 'title' ) ), null );
		$instance = wp_parse_args( (array)$instance, $defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'odin' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<?php foreach( $this->services as $id=>$name ) { ?>
		<p>
			<label for="<?php echo $this->get_field_id( $id ) ?>"><?php echo $name ?></label>
    		<input type="text" class="widefat" name="<?php echo $this->get_field_name( $id ) ?>" id="<?php echo $this->get_field_id( $id ) ?>" value="<?php echo esc_attr( $instance[$id] ) ?>"/>
    	</p>
		<?php
		}

	}

}

/**
 * Register Widget.
 *
 * @return void
 */
function odin_widget_social_register() {
	register_widget( 'Odin_Widget_Social' );
}

add_action( 'widgets_init', 'odin_widget_social_register' );
