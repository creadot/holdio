<?php get_header(); ?>

<div class="references">
	<div class="container">
		<h1 class="h2">Reference</h1>
		<div class="categories">
			<?php 
				$uncategorized_id = get_cat_ID('Nezařazené');
				$categories = get_categories(array(
				    'hide_empty' => false,
				    'exclude' => array($uncategorized_id)
				));
			?>

			<?php foreach ($categories as $category) : ?>
			    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
			       class="<?php echo (is_category($category->term_id)) ? 'active' : ''; ?>">
			        <?php echo esc_html($category->name); ?>
			    </a>
			<?php endforeach; ?>
		</div>
		<?php if (have_posts()) : ?>
		    <div class="references-list">
		        <?php while (have_posts()) : the_post(); ?>
		            <div class="references-list__item<?php if ( get_field("velikost_dlazdice_na_vypisu") == "medium" ): ?> references-list__item--half<?php elseif ( get_field("velikost_dlazdice_na_vypisu") == "big" ) : ?> references-list__item--big<?php endif; ?>">
		                <a href="<?php the_permalink(); ?>" class="content">
		                	<span class="top">
		                		<?php $categories = get_the_category(); ?>
			                    <?php if (!empty($categories)) : ?>
			                        <span class="label"><?php echo esc_html($categories[0]->name); ?></span>
			                    <?php endif; ?>
			                    <h2 class="h3 alt"><?php the_field("nahled_text"); ?></h2>
			                    
			                    <?php if ( get_field("nahled_logo") ) : ?>
			                        <?php echo Img::img(get_field("nahled_logo")["id"], [ 0,0 ], false, ['alt' => false, 'class' => false]); ?>
			                    <?php endif; ?>
		                	</span>
		                    <span class="date"><?php echo get_the_date('d. m. Y'); ?></span>
		                </a>
		                
		                <?php 
							$velikost = get_field("velikost_dlazdice_na_vypisu");
							$nahled_obrazek = get_field("nahled_obrazek");
							$nahled_video = get_field("nahled_video");
							$obrazek_nebo_video = get_field("nahled_obrazek_nebo_video");
						?>

					 	<?php if ( ($velikost == "medium" || $velikost == "big") && $obrazek_nebo_video == "obrazek" && $nahled_obrazek ): ?>
						    <a href="<?php the_permalink(); ?>" class="image">
						        <img src="<?php echo $nahled_obrazek['url']; ?>" alt="" loading="lazy">
						    </a>
						<?php elseif ( ($velikost == "medium" || $velikost == "big") && $obrazek_nebo_video == "video" && $nahled_video ): ?>
						    <a data-fancybox href="<?php echo $nahled_video['url']; ?>" class="image">
						        <img src="<?php echo $nahled_obrazek['url']; ?>" alt="" loading="lazy">
						        <span class="play-icon"><i class="fa-solid fa-play"></i></span>
						    </a>
						<?php endif; ?>
		                
		            </div>

		            <?php wp_reset_postdata(); ?>
		        <?php endwhile; ?>
		    </div>
		<?php endif; ?>

		<?php global $wp_query; ?>
    	<?php if ($wp_query->max_num_pages > 1): ?>
			<div class="pagination">
				<?php
					$args = [
						'total'              => $wp_query->max_num_pages,
						'current'            => max( 1, get_query_var('paged') ),
						'show_all'           => false,
						'end_size'           => 2,
						'mid_size'           => 2,
						'prev_next'          => true,
						'add_args'           => true,
						//'add_fragment'       => "#clanky",
						'prev_text'          => "<span class='circle'></span><i class='fa-light fa-arrow-left'></i>",
						'next_text'          => "<span class='circle'></span><i class='fa-light fa-arrow-right'></i>",
					];
				?>
				<?php echo paginate_links( $args );?>
			</div>
		<?php endif ?>

	</div>

</div>

<?php get_footer(); ?>
