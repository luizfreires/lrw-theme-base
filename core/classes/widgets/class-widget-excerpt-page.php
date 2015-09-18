<?php
/**
 * Odin_Widget_Page_Excerpt class.
 *
 * Page excerpt widget.
 *
 * @package  Odin
 * @category Widget
 */
class Odin_Widget_Page_Excerpt extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_page',
			__( 'Odin - Page excerpt', 'odin' ),
			array(
				'description' => __( 'This widget allows you to view a summary of any page of your site.', 'odin' ),
			)
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
		$title 		= apply_filters( 'widget_title', $instance['title'] );
		$pagename 	= $instance['pagename'];
		$show_thumb = $instance['show_thumb'];

		// Start
		echo $args['before_widget'];

		// Query for loop
		$myquery = new WP_Query();
		$myquery->query( array(
			'page_id' => $pagename
		));

		while ( $myquery->have_posts() ) : $myquery->the_post();

			echo '<article>';
				echo $args['before_title'];
				echo '<a href="' . get_permalink() . '">' . ( ( ! empty( $title ) ) ? $title : get_the_title() ) . '</a>';
				echo $args['after_title'];

				$images = array(
					'numberposts'   	=> -1,
					'order'         	=> 'ASC',
					'orderby'       	=> 'menu_order',
					'post_parent'		=> $post->ID,
					'post_type'			=> 'attachment',
					'post_mime_type' 	=> 'image',
				);

			  	$attachments = get_children( $images );
			  	$total_images = count( $attachments );

				if ( ( $show_thumb == 1 ) && has_post_thumbnail() ) {
					$post_thumbnail = get_the_post_thumbnail( $post_id, 'full', $attr = array( 'class' => 'wp-image-thumb img-responsive' ) );
				} elseif ( $total_images > 0 ) {
					$image          = array_shift( $attachments );
					$post_thumbnail = wp_get_attachment_image( $image, 'full', $attr = array( 'class' => 'wp-image-thumb img-responsive' ) );
				}

				if ( ! empty ( $post_thumbnail ) ) :
					echo '<a class="thumbnail" href="' . get_permalink() . '">' . $post_thumbnail . '</a>';
				endif;

				echo '<div class="entry-content">' . odin_excerpt( 'excerpt', 40 ) . '</div>';
			echo '</article><!-- #post-## -->';

		endwhile;
		wp_reset_postdata();

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
		$instance['title']		= ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['pagename'] 	= ( ! empty( $new_instance['pagename'] ) ) ? strip_tags( $new_instance['pagename'] ) : '';
		$instance['show_thumb']	= ( ! empty( $new_instance['show_thumb'] ) ) ? intval( $new_instance['show_thumb'] ) : 0;

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

		$title		= isset( $instance['title'] ) ? $instance['title'] : '';
		$pagename	= isset( $instance['pagename'] ) ? $instance['pagename'] : '';
		$show_thumb	= isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : '0';

        $odin_dropdown_pages = wp_dropdown_pages(
        	array(
				'echo'				=> 0,
				'id'				=> $this->get_field_id( 'pagename' ),
				'name'				=> $this->get_field_name( 'pagename' ),
				'selected'			=> $instance['pagename'],
				'show_option_all'	=> __( 'All pages', 'odin' ),
				'post_type'			=> 'page',
				'sort_order'		=> 'ASC'
			)
		);

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'odin' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'pagename' ); ?>"><?php _e( 'Choose a page:', 'odin' ); ?></label><br>
			<?php echo $odin_dropdown_pages; ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>">
				<input id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" type="checkbox" value="1" <?php checked( 1, $show_thumb, true ); ?> /> <?php _e( 'Show thumb, if available', 'odin' ); ?>
			</label>
		</p>

	<?php

	}

}

/**
 * Register Widget.
 *
 * @return void
 */
function odin_widget_page_register() {
	register_widget( 'Odin_Widget_Page_Excerpt' );
}

add_action( 'widgets_init', 'odin_widget_page_register' );
