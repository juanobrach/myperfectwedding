<?php

add_shortcode('post_grid_gallery', 'post_grid_gallery_fn' );

function post_grid_gallery_fn($atts){
	$a = shortcode_atts( array(
		"post_type"=>''
	),$atts);
	$pictures = array(); 
	foreach ( get_post_meta($a['post_type'], 'image') as $picture) {
	 	$pictures[] = wp_get_attachment_url($picture['ID']);
	}
  $item_size = array(
  	array( 'size-1-1'),
  	array( 'size-1-1','size-1-1'),
  	array( 'size-1-1','size-5-1','size-5-1','size-1-1'),
  	array( 'size-3-1','size-5-1','size-5-5','size-1-1','size-2-1'),
  );
  switch ( count( $pictures) ) {
  	case 1:
  		$layout_selected = $item_size[0];
  		break;
		case 2:
			$layout_selected = $item_size[1];
		break;
		case 3:
			$layout_selected = $item_size[2];
		break;
		default:
			$layout_selected = $item_size[3];
		break;
  }

  $c = -1;
  $counted = 0;
  $layout = "<section id='post_grid_gallery'>
              <div class='grid'>
                <div class='grid-sizer'></div>";

	foreach ($pictures as $picture){
		$c +=1;
		$counted += 1;
		$classes =  array("set-width-5","set-width-1","set-width-1","set-width-5","set-width-1","set-width-1","set-width-50","set-width-50");
		if( count($pictures) <= 3 ){
			$layout .=	"<div class='grid-item size-1-1 '> <img  class='box img-bg' src='$picture'> <a class='fancybox' href='$picture'></a></div>";
		}else{
			if( count($pictures) %8 != 1 && count($pictures) > 8 && count($pictures) - $counted < 3  ){
			$layout .= "<div class='grid-item set-width-3'><img src='$picture'><a class='fancybox' href='$picture'></a></div>";			
			}else{
			$layout .= "<div class='grid-item ". $classes[$c] ." '><img src='$picture'><a class='fancybox' href='$picture'></a></div>";	
			}
		if($c == 7) $c = -1;
		}
	}
	$layout .= "</div></section>";
	return $layout;

}