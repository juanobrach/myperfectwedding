<?php get_header(); ?>
<?php 
	$id = get_the_ID();
	$content = get_post_meta($id);

?>
<h1><?php single_post_title();?></h1>
<h3><?= $content['client_country'][0] ?></h3>
<p><?= $content['review'][0]; ?></p>
 <?php get_footer(); ?>