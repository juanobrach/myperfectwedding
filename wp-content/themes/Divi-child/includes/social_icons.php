<ul class="et-social-icons social">

<?php if ( get_option( 'custom_settings_facebook') ) : ?>
	<li class="et-social-icon et-social-facebook">
		<a target="_blank" href="<?php echo esc_url( get_option( 'custom_settings_facebook' ) ); ?>" class="icon">
		</a>
	</li>
<?php endif; ?>
<?php if ( get_option( 'custom_settings_twitter') ) : ?>
	<li class="et-social-icon et-social-twitter">
		<a target="_blank" href="<?php echo esc_url( get_option( 'custom_settings_twitter') ); ?>" class="icon">
		</a>
	</li>
<?php endif; ?>
<?php if ( get_option( 'custom_settings_instagram') ) : ?>
	<li class="et-social-icon et-social-instagram">
		<a target="_blank" href="<?php echo esc_url( get_option( 'custom_settings_instagram') ); ?>" class="icon">
		</a>
	</li>
<?php endif; ?>
<?php if ( get_option( 'custom_settings_pinterest') ) : ?>
	<li class="et-social-icon et-social-pinterest">
		<a target="_blank" href="<?php echo esc_url( get_option( 'custom_settings_pinterest' ) ); ?>" class="icon">
		</a>
	</li>
<?php endif; ?>
<?php if ( get_option( 'custom_settings_google') ) : ?>
	<li class="et-social-icon et-social-google-plus">
		<a target="_blank" href="<?php echo esc_url( get_option( 'custom_settings_google' ) ); ?>" class="icon">
		</a>
	</li>
<?php endif; ?>

</ul>