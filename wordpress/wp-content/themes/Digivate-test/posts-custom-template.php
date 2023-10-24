<?php
/**
 * Template Name: posts-custom-template
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package test-digivate
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			while ( have_posts() ) :
				the_post();
				ign_template( 'content' );
			endwhile;
			ign_template( 'src/parts/post/hero-banner.php' );
			ign_template( 'src/parts/post/custom-posts-archive.php' );
			?>
		</main>
	</div>

<?php get_footer(); ?>
