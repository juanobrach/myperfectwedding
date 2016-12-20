<?php get_header(); ?>	
<?php 
	$id = get_the_ID();
?>
<div class="wrapper">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<h1><?php single_post_title();?></h1>
	<hr>
	<?= the_content(); ?>
<?php endwhile; endif; ?>
</div>
	<?php echo do_shortcode('[post_grid_gallery post_type="'.$id.'"]');  ?>
 <?php get_footer(); ?>