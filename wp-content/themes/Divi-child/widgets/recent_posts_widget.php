<?php

// Creating the widget 
class recent_posts_wd extends WP_Widget {

function __construct() {
parent::__construct('recent_posts_wd', 
// Widget name will appear in UI
__('Recent Posts Thumbnails', 'recent_posts_wd_domain'), 
// Widget description
array( 'description' => __( 'See each recent post with their excerpt and featured thumbnail' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
	$args_query = array( 'numberposts' => '5' );
	$recent_posts = wp_get_recent_posts( $args_query );
	foreach( $recent_posts as $recent ){
		$layout = '<li>';
		$layout .= '<a class="thumbnail" href="' . get_permalink($recent["ID"]) . '">' ;
		$layout .=  get_the_post_thumbnail($recent['ID']);
		$layout .= "</a>";
		$layout .= '<a class="title" href="' . get_permalink($recent["ID"]) . '">' ;
		$layout .= 	$recent["post_title"];
		$layout .= "</a>";
		$layout .= "</li>";
	}
	echo $layout;

echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Recent Posts', 'recent_posts_wd_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function load_recent_posts_wd() {
	register_widget( 'recent_posts_wd' );
}
add_action( 'widgets_init', 'load_recent_posts_wd' );

