<?php


include dirname(__FILE__) . '/shortcodes/post_grid_gallery.php';

add_shortcode('grid_reviews', 'get_grid_boxes_reviews');
function get_grid_boxes_reviews(){

	$review_boxes = "";
		$args = array(
			'post_type' => 'review',
			'posts_per_page' => -1,
		);
	$reviews =  new WP_Query($args);
	$count = 0;
	$row = 0;
	$review_boxes = array();
	if( $reviews->have_posts() ):while( $reviews->have_posts() ): $reviews->the_post();
		$count += 1;
		$review_meta = get_post_meta(get_the_ID());
		$title = get_the_title();
		$country = $review_meta['client_country'][0];
		$the_excerpt = substr( get_the_excerpt(),0,160) . " [...]";
		$permalink = get_permalink();
		$box ="
		<div class='content-box box-$count'>
  		<h4>$title</h4>
  		<p>$country</p>
   		<hr />
	   	<div>
	   		$the_excerpt
	    <br>
	    <span><a href=$permalink >read more</a></span>
	   </div>
		</div>";
		$review_boxes[] = $box;
	endwhile; wp_reset_postdata();endif;

	$count = 0;
	$pointer = 0;

	$row_of_3 = array();

	foreach ($review_boxes as $review ) {
		if( $count >= 3 ){
			$count = 0;
			$pointer +=1;
		}
		$row_of_3[$pointer][] = $review;
		$count += 1;
	}

	$row_n = 0;
	$review_rows = array();
	foreach ($row_of_3 as $review) {
		$row_n += 1;
		$row = "<section class='review-comments-row'>";
		foreach ($review as $r) {
			$row .= $r;
		}
		$row .= "<span class='grid-line line bottom-$count'></span>";
		$row .= "</section>";
		$review_rows[] = $row;
	}
	return  implode($review_rows);
}



add_shortcode('grid_categories','grid_categories_fn');
function grid_categories_fn($atts){

	$a = shortcode_atts( array(
		"post_type"=>''
	),$atts);

	// Getting services info
	$args = array(
		'post_type'=>  $a['post_type'],
		'posts_per_page' => -1,
	);
	$services_query = new WP_Query($args);

	$services = array();

	
	if( $services_query->have_posts() ):while( $services_query->have_posts() ): $services_query->the_post();
		
		$services[get_the_ID()] = array(
		 	'name'=>get_the_title(),
		 	'link'=>get_permalink(),
		);
	endwhile;wp_reset_postdata();endif;

	foreach ($services as $service_id => $data ) {
	  	// Getting all post images, and getting the URL - return services array
		$pictures_query = get_post_meta($service_id,'image');
		$pictures = array();
		$c_pictures = 0;
		foreach ($pictures_query as $picture) {
			$c_pictures++;
			if( $c_pictures > 5 ) continue;
		 	$pictures[] = wp_get_attachment_url($picture['ID']);
		}
		$services[$service_id]['pictures'] = $pictures;
	}

	// Preparing services box content
	$layout = "<section id='grid_categories'><ul>";
	foreach ($services as $service) {
		$layout.="<li>
	  						<a href='$service[link]'>
	  							<h3>$service[name]</h3>
		  						<div class='pictures'>";
									  $count = 0;
									  foreach ($service['pictures'] as $picture) {
									  	$count += 1;
									  	if($count === 1){
									  		$layout.= "<div class='img-bg showMe' style='background-image:url($picture)'/></div>";
									  	}else{
									  		$layout.="<div class='img-bg' style='background-image:url($picture)'/></div>";
									  	}
									  }
				$layout.="</div></a></li>";
	}
	$layout.="<ul></section>";
	return $layout;
}
