<?php
/**
 * @package Cactus Masonry Plus
 * @version 0.0.5.5
 */
/*
 * Plugin Name: Cactus Masonry Plus
 * Plugin URI: cactus.cloud
 * Description: A highly customizable gallery of post thumbnails. 
 * Version: 0.0.5.5
 * Author: cactus.cloud
 * Author URI: http://cactus.cloud/masonryplus
 * License: GNU AGPLv3

    Copyright (C) 2016 cactus.cloud

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published
    by the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class cactus_masonry_plus {	
	
	private static $a = null;
	private static $VERSION = "0.0.5.5";
	
	static public function init() {
		include_once('cactusMasonryGettingStarted.php');
		add_shortcode("cactusMasonry", array(__CLASS__, "cactus_masonry_shortcode_handler"));
		add_shortcode("cactusmasonry", array(__CLASS__, "cactus_masonry_shortcode_handler"));
		add_action("wp_enqueue_scripts", array(__CLASS__, "cactus_masonry_scripts"), 42);
		add_action("admin_menu", "cactus_masonry_plus_intro");
		//ADD JQUERY TO HEAD
		$plugin = plugin_basename(__FILE__);
		add_filter("plugin_action_links_$plugin", array(__CLASS__, 'cactus_masonry_links'));
	}

	static public function cactus_masonry_scripts() {
		if(!wp_script_is("jquery", "enqueued") || !wp_script_is("jquery", "registered")) wp_enqueue_script("jquery", includes_url() . 'js/jquery/jquery.js', array(), false, true);		
		wp_enqueue_script('cactusBrickScript', plugin_dir_url(__FILE__) . 'cactusBrick.min.js', array('jquery'), self::$VERSION, true);
		wp_enqueue_script('cactusGalleryScript', plugin_dir_url(__FILE__) . 'cactusGallery.min.js', array('jquery', 'cactusBrickScript'), self::$VERSION, true);
		wp_enqueue_script('cactusMasonryPlusScript', plugin_dir_url(__FILE__) . 'cactusMasonryPlus.min.js', array('jquery', 'cactusBrickScript', 'cactusGalleryScript'), self::$VERSION, true);
		wp_enqueue_style('cactusMasonryPlusStyle', plugin_dir_url(__FILE__) . 'style.css');		
	}
	
	static public function cactus_masonry_links($links) {
		$newlink = "<a href='https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=forum%40cactus%2ecloud&lc=AU&item_name=cactus%2ecloud&item_number=masonry&currency_code=AUD&'>Donate</a>";
		array_unshift($links, $newlink);
		$newlink = "<a href='http://cactus.cloud/masonryplus' target='_blank'>Instructions</a>";
		array_unshift($links, $newlink);
		$newlink = "<a href='http://support.cactus.cloud' target='_blank'>Help & Support</a>";
		array_unshift($links, $newlink);
		return $links;
	}
	
	static public function cactus_masonry_shortcode_handler($atts) {
		//Accept input parameters
		$defaultAtts = array(
			//JS
			'id'						=>	"cactus" . mt_rand(10000,99999),
			
			//Functionality
			'paginate' 					=> 	true,
			
			//Query parameters
			'categoryslug'				=> "",
			'withthumbnail'				=> true,
			'withoutthumbnail'			=> true,
			'orderby'					=> "",
			'gallerymode'				=> false,
			'posttype'					=> "post,page",
			'includedpostids'			=> "",
			'excludedpostids'			=> "",
			'metakey'					=> "",

			//Query Size
			'pagesize'					=>	20,
			'offset'					=>	null,

			//Images
			'imagequality'				=> "medium",

			//Post Data
			'showtitle'					=> false,
			'showcategory'				=> false,
			'showexcerpt'				=> false,

			//Author Metadata
			'showauthor'				=> false,
			'showauthoraslink'			=> false,

			//Date metadata
			'showdate'					=> false,
			'dateformat'				=> "",

			//Lightbox
			'lightbox'					=> false,
			
			//infinitescroll
			'infinitescroll'			=> false,
			
			'lazyload'					=> false,
			
			//Appearance
			'width'						=> "auto",
			'height'					=> "auto",
			'minwidth'					=> "150px",
			'minheight'					=> "150px",
			'maxwidth'					=> "auto",
			'maxheight'					=> "auto",
			
			'shrinktofitfactor'			=> 0.7,
			
			'theme'						=> "c1",
			'defaultcolor'				=> "pastel",
			'margin'					=> 30,
			
			'linkaction'				=> "post"
		);
		self::$a = self::check_shortcode($defaultAtts, $atts);
		$errors = array();
		
		//Standardize some measurements
		if(self::$a["width"] == null || self::$a["width"] == "") self::$a["width"] = "auto";
		if(self::$a["height"] == null || self::$a["height"] == "") self::$a["height"] = "auto";
		if(self::$a["minwidth"] == null || self::$a["minwidth"] == "") self::$a["minwidth"] = "auto";
		if(self::$a["minheight"] == null || self::$a["minheight"] == "") self::$a["minheight"] = "auto";
		if(self::$a["maxwidth"] == null || self::$a["maxwidth"] == "") self::$a["maxwidth"] = "auto";
		if(self::$a["maxheight"] == null || self::$a["maxheight"] == "") self::$a["maxheight"] = "auto";
		
		//Check image quality
		$q = self::$a["imagequality"];
		if($q != "thumbnail" && $q != "medium" && $q != "large" && $q != "full") {
			$qd = $defaultAtts["imagequality"];
			$errors[] = "Invalid imageQuality of \"{$q}\" specified.  Setting to default value \"{$qd}\".  Possible values are \"thumbnail\", \"medium\", \"large\", and \"full\".";
			self::$a["imagequality"] = $qd;
		}
		
		//Prepare offset
		if(self::$a['paginate']) {
			$page = 1;
			if(self::$a['offset'] == null) {
				$p = intval((get_query_var('paged')) ? get_query_var('paged') : 1);
				if($p != 0) {
					$page = $p;
					self::$a['offset'] = (($p - 1) * self::$a['pagesize']);
				} else self::$a['offset'] = 0;
			}
		}
		//Set up meta query
		$meta = array();
		//Check for gallery mode
		if(self::$a['gallerymode']) {
			if(!self::$a['withthumbnail']) {
				self::$a['withthumbnail'] = true;
				$errors[] = "Cannot filter by thumbnail when galleryMode=\"true\".  Settings withThumbnail to \"true\".";
			}
			if(!self::$a['withoutthumbnail']) {
				self::$a['withoutthumbnail'] = true;
				$errors[] = "Cannot filter by thumbnail when galleryMode=\"true\".  Settings withoutThumbnail to \"true\".";
			}
		} else if(!self::$a['withthumbnail'] || !self::$a['withoutthumbnail']) {//If the presence or absence of thumbnails will affect the query:
			//Thumbnails required
			if(self::$a['withthumbnail']  && !self::$a['withoutthumbnail']) array_push($meta, array (
																							'key'	=> '_thumbnail_id',
																							'compare' => 'EXISTS'
																						));
			//Only show posts without thumbnails
			else if(!self::$a['withthumbnail']  && self::$a['withoutthumbnail']) array_push($meta, array (
																							'key'	=> '_thumbnail_id',
																							'compare' => 'NOT EXISTS'
																						));
			//Posts with and without thumbnails should be hidden
			else $errors[] = "There can be no results when withThumbnail=\"false\" and withoutThumbnail=\"false\".";
		}

		
		$args = array(	"posts_per_page"	=> self::$a["pagesize"],
						"post_type"			=> self::parse_csv(self::$a["posttype"]),
						"offset"        	=> self::$a["offset"],
						"category_name" 	=> self::$a["categoryslug"],
						"meta_query"		=> $meta
					);
						
		//Get included ids
		if(self::parse_csv(self::$a["includedpostids"]) != "") {
			$ids_in = self::parse_csv(self::$a["includedpostids"]);
			if($ids_in[0] != "") $args['post__in'] = $ids_in;
		}
		if(self::parse_csv(self::$a["excludedpostids"])) {
			$ids_out = self::parse_csv(self::$a["excludedpostids"]);
			if($ids_out[0] != "") $args['post__not_in'] = $ids_out;	
		}
		$args['meta_key'] = self::$a["metakey"];
		
		//Get result order
		$order = self::parse_query_order(self::$a['orderby']);
		if($order != "") $args['orderby'] = $order;
				
		//Add gallery search
		if(self::$a['gallerymode']) $args['s'] = "[gallery"; //The start of a WP gallery shortcode
		
		//Handle invalid searches
		if(count($errors) > 0) {
			self::report_error("Cactus Masonry Plus error:\\n\\t" . implode("\\n\\t", $errors));
			return;
		}
				
		$the_query = new WP_Query($args);
		
		//DEBUG echo "<p>REQUEST:$the_query->request</p>";
		//For each post:
		
		$id = self::$a["id"];
		
		$o = "<div class=\"cactusMasonry\" id=\"{$id}\">";
		$o .= "<div class=\"galleryOuter\">";
		$o .= "<div class=\"gallery " . self::$a["theme"] . "\">";
		$o .= "</div>";
		$o .= "</div>";
		if($the_query->have_posts()) {
			$themes_width_solid_meta = array("metabelow");
			//Set up main JS
			$o .= "<script>";
			$o .= "document.addEventListener(\"DOMContentLoaded\", function() {";
			$o .= "var cmp{$id} = new CactusMasonryPlus();";
			$o .= "cmp{$id}.margin = " . (self::$a['margin']/2) . ";";
			$o .= "cmp{$id}.brickH = \"" . self::$a['height'] . "\";";
			$o .= "cmp{$id}.brickW = \"" . self::$a['width'] . "\";";
			$o .= "cmp{$id}.brickMinW = \"" . self::$a['minwidth'] . "\";";
			$o .= "cmp{$id}.brickMinH = \"" . self::$a['minheight'] . "\";";
			$o .= "cmp{$id}.brickMaxW = \"" . self::$a['maxwidth'] . "\";";
			$o .= "cmp{$id}.brickMaxH = \"" . self::$a['maxheight'] . "\";";
			$o .= "cmp{$id}.defaultColor = \"" . self::$a['defaultcolor'] . "\";";
			$o .= "cmp{$id}.tolerance = " . self::$a['shrinktofitfactor'] . ";";
			$o .= "cmp{$id}.evalMeta = " . ((in_array(self::$a['theme'], $themes_width_solid_meta)) ? "true" : "false") . ";";
			$o .= "cmp{$id}.infiniteScroll = " . ((self::$a['infinitescroll']) ? "true" : "false") . ";";
			$o .= "cmp{$id}.lazyLoad = " . ((self::$a['lazyload']) ? "true" : "false") . ";";
			$o .= "cmp{$id}.lightbox = " . ((self::$a['lightbox']) ? "true" : "false") . ";";
			$o .= "cmp{$id}.init(document.getElementById(\"{$id}\"));";
			$o .= "var b;";
			$linkaction = self::$a['linkaction'];
			while($the_query->have_posts()) {
				$the_query->the_post();
				//Draw the gallery from the post
				if(self::$a["gallerymode"] && get_post_gallery()) {
					$gallery = get_post_gallery(get_the_ID(), false);
					$gallery_ids = explode(",", $gallery["ids"]);
					//Add each gallery image
					for($i = 0, $j = count($gallery_ids); $i < $j; $i++) {
						$thumb = wp_get_attachment_image_src($gallery_ids[$i], self::$a['imagequality']);
						$o .= "b = new CactusMasonryBrick();";
						$o .= "b.img = \"{$thumb[0]}\";";
						$o .= "b.w = {$thumb[1]};";
						$o .= "b.h = {$thumb[2]};";		
						//Set up the post link
						if($linkaction == "full" || $linkaction == "large" || $linkaction == "medium" || $linkaction == "thumbnail") $o .= "b.url = \"" . wp_get_attachment_image_src($gallery_ids[$i], $linkaction)[0] . "\";";
						//Load or lazy load gallery brick
						if(self::$a['lazyload']) $o .= "cmp{$id}.queueBrick(b);";
						else $o .= "cmp{$id}.addBrick(b);";
					}
				} else {//Draw the actual post
					$o .= "b = new CactusMasonryBrick();";
					//Get thumbnail
					$thumb = null;
					$tId = get_post_thumbnail_id($the_query->post->ID);
					if(has_post_thumbnail()) $thumb = wp_get_attachment_image_src($tId, self::$a['imagequality']);
					if($thumb == null) $thumb = false;
					if($thumb != false) {
						$o .= "b.img = \"{$thumb[0]}\";";
						$o .= "b.w = {$thumb[1]};";
						$o .= "b.h = {$thumb[2]};";					
					}
					//Set up the post link
					if($linkaction == "post") $o .= "b.url = \"" . get_permalink() . "\";";
					else if($thumb != false && ($linkaction == "full" || $linkaction == "large" || $linkaction == "medium" || $linkaction == "thumbnail")) $o .= "b.url = \"" . wp_get_attachment_image_src($tId, $linkaction)[0] . "\";";
					//Add meta data
					if(self::$a['showtitle']) $o .= "b.title = \"" . get_the_title() . "\";";
					if(self::$a['showcategory']) {
						$cats = get_the_category();
						if(!empty($cats)) {
							$o .= "b.category = \"";
							for($i = 0, $j = count($cats); $i < $j; $i++) {
								$o .= "<span>" . $cats[$i]->name . "</span>";
							}
							$o .= "\";";
						}
					}
					if(self::$a['showexcerpt']) $o .= "b.excerpt = \"" .  wp_trim_excerpt() . "\";";
					
					if(self::$a['showauthor']) {
						$auth = get_the_author_meta('user_nicename');
						$o .= "b.author = \"" . $auth . "\";";
						if(self::$a['showauthoraslink']) $o .= "b.authorUrl = \"" . get_author_posts_url(get_the_author_meta("ID"), $auth) . "\";";
					}
					if(self::$a['showdate']) {
						if(self::$a['dateformat'] == "") $o .= "b.date = \"" . get_the_date() . "\";";
						else $o .= "b.date = \"" . get_the_date(self::$a['dateformat']) . "\";";
					}
					//Load or lazy load gallery brick
					if(self::$a['lazyload']) $o .= "cmp{$id}.queueBrick(b);";
					else $o .= "cmp{$id}.addBrick(b);";
				}
			}
			$o .= "});";
			$o .= "</script>";
			
		}
		//Do pagination
		if(self::$a['paginate']) {
			$o .= "<div class=\"pages\">";
			$o .= paginate_links(array(	'base'   => @add_query_arg('paged','%#%'),
							//'format'             => '?paged=%#%',
							'total'              => $the_query->max_num_pages,
							'current'            => $page,
							'show_all'           => false,
							'end_size'           => 1,
							'mid_size'           => 2,
							'prev_next'          => true,
							'prev_text'          => __('« Previous'),
							'next_text'          => __('Next »'),
							'type'               => 'plain',
							'add_args'           => false,
							'add_fragment'       => '',
							'before_page_number' => '',
							'after_page_number'  => ''));
			$o .= "</div>";
		}
		$o .= "</div>";
		wp_reset_postdata();
	
		return $o;
	}
	
	static private function sanitize($b) {
		return esc_sql($b);
	}
	
	static private function parse_csv($s) {
		return array_map("trim", explode(",", $s));
	}
	
	static private function check_boolean($b, $default) {
		if($b === true || $b === false) return $b;
		if(trim(strtolower($b)) == "true") return true;
		if(trim(strtolower($b)) == "false") return false;
		return $default;
	}
	
	static private function check_integer($i, $default) {
		if($i == null || $i == "") return $default;
		if(((string)(int)$i) == $i) return (int)$i;
		return $default;
	}
		
	static private function check_shortcode($defaults, $a) {
		if(gettype($a) != "array") return $defaults;
		$out = array();
		$errors = array();
		
		//For each attribute key - value pair:
		reset($defaults);
		foreach($defaults as $key => $defval) {
			//Check the key is valid
			if(array_key_exists($key, $a)) {
				$type = gettype($defval);
				if($type == "boolean") $out[$key] = self::check_boolean($a[$key], $defval);
				else if($type == "integer" || $type == "double") $out[$key] = self::check_integer($a[$key], $defval);
				else if($key == "dateformat") $out[$key] = trim($a[$key]);				
				else $out[$key] = trim(strtolower(self::sanitize($a[$key])));				
			} else $out[$key] = $defval;
		}
		
		//Check for invalid parameters
		reset($a);
		foreach($a as $key => $val) {
			if(gettype($key) == "integer") $errors[] = $val;
			else if(!array_key_exists($key, $defaults)) $errors[] = $key . "=\"" . $val . "\"";
		}
		
		//Report errors
		if(count($errors) > 0) self::report_error("Cactus Masonry Plus error:\\n\\tThe following invalid shortcode parameters have been entered:\\n\\t\\t" . implode("\\n\\t\\t", $errors));
		
		return $out;
	}
	
	/** Parses the orderby list into an array.  Checks for an invalid input
	Input examples:		title desc, date asc, views, author asc
	
	Output examples:	array( 'title' => 'DESC', 'menu_order' => 'ASC' )
	
	If a termed pair has no order specified (asc or desc) defualt to desc.
	**/
	static private function parse_query_order($o) {
		if($o == "" || gettype($o) != "string") return "";
		$out = array();
		$errors = array();
		
		//Separate and iterate through each comma separated term
		$os = explode(",", strtolower($o));
		for($x = 0, $y = count($os); $x < $y; $x++) {
			$order = explode(" ", trim($os[$x]));
			//Check for invalid length
			$s = count($order);
			//Set default order
			if($s == 1) $out[trim($order[0])] = "desc";
			else if($s == 2) {//Attempt to use user-specified order
				$d = trim($order[1]);
				//Check valid order has been specified - otherwise, report error
				if($d == "desc" || $d == "asc") $out[trim($order[0])] = $d;
				else $errors[] = trim($os[$x]);
			} else $errors[] = trim($os[$x]);			
		}
		
		if(count($errors) > 0) self::report_error("Cactus Masonry Plus error:\\n\\tThe following orderBy values are incorrectly formatted:\\n\\t\\t" . implode("\\n\\t\\t", $errors));
		
		if(count($out) == 0) return "";
		
		return $out;
	}
	
	static private function report_error($e) {
		echo "<script>console.log(\"" . str_replace("\"", "'", $e) . "\")</script>";
	}
}
cactus_masonry_plus::init();
?>