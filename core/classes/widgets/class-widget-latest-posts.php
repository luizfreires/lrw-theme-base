<?php
/**
 * odin_Widget_Posts class.
 *
 * Latest posts widget.
 *
 * @package  Odin
 * @category Widget
 */
class Odin_Widget_Posts extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_posts',
			__( 'Odin - Latest posts', 'odin' ),
			array(
				'description' => __( 'Display latest post.', 'odin' ),
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
		$num_posts	= $instance['num_posts'];
		$category 	= $instance['category'];

		// Start
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Query for loop
		$myquery = new WP_Query();
		$myquery->query( array(
			'post_type'      => 'post',
			'posts_per_page' => $num_posts,
			'cat' 			 => $category
		));

		while ( $myquery->have_posts() ) : $myquery->the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<div class="entry-meta">
						<?php odin_posted_on(); ?>
					</div><!-- .entry-meta -->
					<h5 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h5><!-- .entry-title -->
            	</header><!-- .entry-header -->
	        </article>

    	<?php

    	endwhile;
    	wp_reset_query();

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
		$instance['title']     = ( ! empty( $new_instance['title'] ) )     ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['num_posts'] = ( ! empty( $new_instance['num_posts'] ) ) ? intval( $new_instance['num_posts'] ) : 3;
		$instance['category']  = ( ! empty( $new_instance['category'] ) )  ? strip_tags( $new_instance['category'] ) : '';

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

		$title 		= isset( $instance['title'] )     ? $instance['title'] : '';
		$num_posts	= isset( $instance['num_posts'] ) ? $instance['num_posts'] : 3;
        $category 	= isset( $instance['category'] )  ? $instance['category'] : '';

		$dropdown_categories = wp_dropdown_categories( array(
			'echo'			  => 0,
			'name'			  => $this->get_field_name( 'category' ),
			'selected' 		  => $instance['category'],
			'show_option_all' => __( 'All Categories', 'odin' ),
			'class' 		  => 'widefat'
		));

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'num_posts' ); ?>"><?php _e( 'Number of posts to display:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'num_posts' ); ?>" name="<?php echo $this->get_field_name( 'num_posts' ); ?>" value="<?php echo $instance['num_posts']; ?>" />
		</p>

    	<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Categories:', 'odin' ) ?></label>
			<?php echo $dropdown_categories; ?>
        </p>

		<?php
	}

}

/**
 * Register Widget.
 *
 * @return void
 */
function odin_widget_posts_register() {
	register_widget( 'Odin_Widget_Posts' );
}

add_action( 'widgets_init', 'odin_widget_posts_register' );