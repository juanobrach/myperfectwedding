<?php

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct('wpb_widget', 
// Widget name will appear in UI
__('Featured Post', 'wpb_widget_domain'), 
// Widget description
array( 'description' => __( 'Add a simple gallery for your sidebar blog with your featured posts image and information' ), ) 
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
$args_q = array(
	'post_type' => 'post',
	'meta_key'  => 'featured',
	'meta_query' => array(
		array(
			'key'     => 'featured',
			'value'   => array( true ),
			'compare' => 'IN',
		),
	),
);
$query = new WP_Query( $args_q );

$layout  = "<section id='featured_post_widget'>";
$layout .=  "<ul class='slides'>";
if( $query->have_posts() ){
	 while( $query->have_posts() ){
	 	$layout .= "<li>";
	 	$layout .= "<a href='". get_page_link() ."'/>";
	 	 $query->the_post(); 
	 	 $layout .= get_the_post_thumbnail();
	   $layout .= "<p>". substr(get_the_excerpt(),0,130) ."</p>";
	   $layout .= "</a>";
	  $layout .= "</li>";
	}
	$layout .= "</ul>";
	$layout .= "</section>";
	wp_reset_postdata();
}else{
	echo "no founded";
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
$title = __( 'Featured post', 'wpb_widget_domain' );
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
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

