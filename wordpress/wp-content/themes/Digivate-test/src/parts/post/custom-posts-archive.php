<?php

/**
 * @package Digivate-test
 * @since   4.0
 *
 * Display a custom posts archive section
 */

?>

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
