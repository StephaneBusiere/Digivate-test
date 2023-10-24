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

<section  class="posts-archive-section">
			<?php
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			$posts = new WP_Query(
				array(
					'post_type' => 'post',
					'order_by'  => 'date',
					'order'     => 'desc',
					'paged'     => $paged,
				)
			);
			?>
			<div class="loader-container"></div>
			<div class="posts-archives-wrapper">
				<?php if ( $posts->have_posts() ) : ?>
					<?php
					while ( $posts->have_posts() ) :
						$posts->the_post();
						$categories = get_the_category();
						?>
				<div class="posts-archives-container">
					<div class="posts-archives-text-left">
						<h4 class="posts-archives-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="posts-archives-category-container">
						<?php
						foreach ( $categories as $category ) {
							?>
								<div class="posts-archives-category"><?php echo esc_html( $category->name ); ?></div>
						<?php } ?>
						</div>
					</div>
					<div class="posts-archives-thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a></div>

				</div>
						<?php wp_reset_postdata(); ?>
						<?php
				endwhile;
					endif;
				?>
			</div>
				<section class="pager m-50">
								<div class="row">
									<div class="pagination-container">
									<?php
									$big = 999999999;

									echo paginate_links(
										array(
											'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format'    => '?paged=%#%',
											'current'   => max( 1, get_query_var( 'paged' ) . '/' ),
											'total'     => $posts->max_num_pages,
											'prev_next' => true,
											'prev_text' => '<span >← Previous</span>',
											'next_text' => '<span >Next →</span>',
										)
									);


									?>
									</div>
								</div>
			</section>
</section>
