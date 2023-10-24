<?php

/**
 * @package Digivate-test
 * @since   4.0
 *
 * Display a custom hero banner with ACF fields
 */


$post_hero_banner_title = get_field( 'post_hero_banner_title' );
$post_hero_banner_text  = get_field( 'post_hero_banner_text' );
$post_hero_banner_image = get_field( 'post_hero_banner_image' );

?>




<section class="hero-banner-container">
	<div class="hero-banner-description">
		<h3 class="hero-banner-title">
			<?php echo wp_kses_post( $post_hero_banner_title ); ?>
		</h3>
		<p class="hero-banner-text">
			<?php echo wp_kses_post( $post_hero_banner_text ); ?>
		</p>
	</div>
	<div class="hero-banner-image-container">
		<img class="hero-banner-image" src="<?php echo esc_url( $post_hero_banner_image ); ?>" alt="">
	</div>
</section>

