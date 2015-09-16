<?php
/**
 * Odin_Widget_Twitter class.
 *
 * Twitter widget.
 *
 * @package  Odin
 * @category Widget
 */
class Odin_Widget_Twitter extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_twitter', // Base ID
			__( 'Odin - Twitter Feed', 'odin' ), // Name
			array(
			'description' => __( 'Display a Twitter feed.', 'odin' ),
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
		$title 				= apply_filters( 'widget_title', $instance['title'] );
		$username 			= empty( $instance['username'] ) ? '' : $instance['username'];
		$count 				= empty( $instance['count'] ) ? ' ' : $instance['count'];
		$consumerkey		= empty( $instance['consumerkey'] ) ? '' : $instance['consumerkey'];
		$consumersecret		= empty( $instance['consumersecret'] ) ? ' ' : $instance['consumersecret'];
		$accesstoken 		= empty( $instance['accesstoken'] ) ? ' ' : $instance['accesstoken'];
		$accesstokensecret 	= empty( $instance['accesstokensecret'] ) ? ' ' : $instance['accesstokensecret'];

		// set configs
		$transName = 'list_tweets';
	    $cacheTime = 10;

	    if ( false == ( $twitterData = get_transient( $transName ) ) ) {
			require_once get_template_directory_uri() . '/core/libs/twitteroauth/twitteroauth.php';

			$twitterConnection = new TwitterOAuth(
				$consumerkey,	   	// Consumer Key
				$consumersecret,   	// Consumer secret
				$accesstoken,      	// Access token
				$accesstokensecret 	// Access token secret
			);

			$twitterData = $twitterConnection->get(
				'statuses/user_timeline',
				array(
					'screen_name'     => $username,
					'count'           => $count,
					'exclude_replies' => false
				)
			);

			if( $twitterConnection->http_code != 200 ) {
				$twitterData = get_transient($transName);
			}

	        // Save our new transient.
	        set_transient( $transName, $twitterData, 60 * $cacheTime );
	    }

	    // Start
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		?>

		<div class="twitter-box">
			<?php

				if( ! empty( $twitterData ) || !isset( $twitterData['error'] ) ) {
            		$i = 0;
					$hyperlinks = true;
					$encode_utf8 = true;
					$twitter_users = true;
					$update = true;

					echo '<ul class="list-unstyled">';

		            foreach( $twitterData as $item ) {

		                    $msg = $item->text;
		                    $permalink = 'http://twitter.com/#!/' . $username . '/status/' . $item->id_str;
		                    if( $encode_utf8 ) $msg = $msg;
                                    $msg = $this->encode_tweet( $msg );
		                    $link = $permalink;

		                    echo '<li class="twitter-item">';

		                      if ( $hyperlinks ) { $msg = $this->hyperlinks( $msg ); }
		                      if ( $twitter_users )  { $msg = $this->twitter_users( $msg ); }

		                      echo $msg;

		                    if( $update ) {
		                      $time = strtotime( $item->created_at );

		                      if ( ( abs( time() - $time ) ) < 86400 )
		                        $h_time = sprintf( __( '%s ago' ), human_time_diff( $time ) );
		                      else
		                        $h_time = date( __( 'Y/m/d' ), $time );

		                      echo sprintf( __( '%s', 'odin' ), ' <span class="twitter-timestamp"><abbr title="' . date( __( 'Y/m/d H:i:s' ), $time ) . '">' . $h_time . '</abbr></span>' );
		                     }

		                    echo '</li>';

		                    $i++;
		                    if ( $i >= $count ) break;
		            }

					echo '</ul>';

            	}

			?>
		</div>

	<?php
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
		$instance['title']				= ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['username']			= ( ! empty( $new_instance['username'] ) ) ? sanitize_text_field( $new_instance['username'] ) : '';
		$instance['count']				= ( ! empty( $new_instance['count'] ) ) ? intval( $new_instance['count'] ) : 3;
		$instance['consumerkey']		= ( ! empty( $new_instance['consumerkey'] ) ) ? intval( $new_instance['consumerkey'] ) : '';
		$instance['consumersecret']		= ( ! empty( $new_instance['consumersecret'] ) ) ? intval( $new_instance['consumersecret'] ) : '';
		$instance['accesstoken']		= ( ! empty( $new_instance['accesstoken'] ) ) ? intval( $new_instance['accesstoken'] ) : '';
		$instance['accesstokensecret']	= ( ! empty( $new_instance['accesstokensecret'] ) ) ? intval( $new_instance['accesstokensecret'] ) : '';

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

		$title 				= isset( $instance['title'] ) ? $instance['title'] : __( 'Twitter', 'odin' );
		$username           = isset( $instance['username'] ) ? $instance['username'] : '';
		$count				= isset( $instance['count'] ) ? $instance['count'] : '';
		$consumerkey		= isset( $instance['consumerkey'] ) ? $instance['consumerkey'] : '';
		$consumersecret		= isset( $instance['consumersecret'] ) ? $instance['consumersecret'] : '';
		$accesstoken 		= isset( $instance['accesstoken'] ) ? $instance['accesstoken'] : '';
		$accesstokensecret	= isset( $instance['accesstokensecret'] ) ? $instance['accesstokensecret'] : '';

        ?>

        <p>
        	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Account:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of tweets:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'consumerkey' ); ?>"><?php _e( 'Consumer Key:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'consumerkey' ); ?>" name="<?php echo $this->get_field_name( 'consumerkey' ); ?>" value="<?php echo $instance['consumerkey']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'consumersecret' ); ?>"><?php _e( 'Consumer Secret:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'consumersecret' ); ?>" name="<?php echo $this->get_field_name( 'consumersecret' ); ?>" value="<?php echo $instance['consumersecret']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'accesstoken' ); ?>"><?php _e( 'Access Token:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'accesstoken' ); ?>" name="<?php echo $this->get_field_name( 'accesstoken' ); ?>" value="<?php echo $instance['accesstoken']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'accesstokensecret' ); ?>"><?php _e( 'Access Token Secret:', 'odin' ) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'accesstokensecret' ); ?>" name="<?php echo $this->get_field_name( 'accesstokensecret' ); ?>" value="<?php echo $instance['accesstokensecret']; ?>" />
		</p>

        <?php
	}


	/**
	 * Find links and create the hyperlinks
	 */
	private function hyperlinks( $text ) {
	    $text = preg_replace( '/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&#038;%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text );
	    $text = preg_replace( '/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&#038;%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text );

	    // match name@address
	    $text = preg_replace( "/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text );
	        //mach #trendingtopics. Props to Michael Voigt
	    $text = preg_replace( '/([\.|\,|\:|\|\|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text );
	    return $text;
	}

	/**
	 * Find twitter usernames and link to them
	 */
	private function twitter_users( $text ) {
		$text = preg_replace( '/([\.|\,|\:|\|\|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text );
		return $text;
	}

    /**
     * Encode single quotes in your tweets
     */
    private function encode_tweet( $text ) {
        $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8" );
        return $text;
    }


}

/**
 * Register Widget.
 *
 * @return void
 */
function odin_widget_twitter_register() {
	register_widget( 'Odin_Widget_Twitter' );
}

add_action( 'widgets_init', 'odin_widget_twitter_register' );
