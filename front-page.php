<?php get_header(); ?>

<?php 

	$current_language = pll_current_language();
	$homepage_id = pll_get_post(2, $current_language); 

	$_services = array(
	    'post_type' => 'service_cpt',
	    'post_status'    => 'publish',
	    'posts_per_page' => -1,
	    'lang' => $current_language
	);
	$services = new WP_Query($_services);

	$_companies_hero = array(
	    'post_type' => 'company_cpt',
	    'post_status'    => 'publish',
	    'posts_per_page' => -1,
	    'lang' => $current_language
	);
	$companies_hero = new WP_Query($_companies_hero);

	$all_terms = get_terms([
	    'taxonomy'   => 'service_cat',
	    'hide_empty' => true,
	    'lang'       => $current_language
	]);

	$_references = array(
	    'post_type' => 'post',
	    'post_status'    => 'publish',
	    'posts_per_page' => 6,
	    'lang' => $current_language
	);
	$references = new WP_Query($_references);
	$uncategorized_id = get_cat_ID('Nezařazené');
	$references_terms = get_terms([
	    'taxonomy'   => 'category',
	    'hide_empty' => false,
	    'exclude' => array($uncategorized_id),
	    'lang'       => $current_language
	]);

	
?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="homepage">

		<div class="homepage__hero">
			<div class="text-wrapper">
				<div class="container">
					<div class="inner">
						<h1 class="h1"><?php echo get_field("nadpis"); ?> <span class="site-name">holdio <sup>*</sup></span></h1>
						<?php if ( $companies_hero->have_posts() ) : $i = 0; ?>
							<div class="companies h1">
								<div class="companies__items">
							        <?php while ( $companies_hero->have_posts() ) : $companies_hero->the_post(); ?>
										<span><?php the_title(); ?></span>
									<?php endwhile; ?>
								</div>
							</div>
						<?php endif; ?>
						<div class="trigger" id="perex"></div>
					</div>
				</div>
			</div>
			<?php if ( get_field("obrazek_video_video") || get_field("obrazek_video_obrazek") ): ?>
				<div class="video-wrapper">
					<?php if ( get_field("obrazek_video_vyberte") == "video" ): ?>
						<video src="<?php echo get_field('obrazek_video_video')['url']; ?>" width="1920" height="1000" playsinline="" autoplay="" muted="" loop="" loading="lazy"></video>
					<?php elseif ( get_field("obrazek_video_vyberte") == "obrazek" ): ?>
						<?php echo Img::img(get_field("obrazek_video_obrazek")["id"], [ 1920, 1000 ], false, ['alt' => false, 'class' => false]); ?>
					<?php endif ?>
					<div id="homepage-hero-video" class="trigger"></div>
				</div>
			<?php endif ?>
			
		</div>

		<div id="<?php echo get_field("service_anchor", $homepage_id); ?>" class="services-list-bg-anchor"></div>
		<div class="services-list services-list--bg">
			<div class="container">
				<div class="inner">
					<p class="h1"><?php echo get_field("service_title", $homepage_id); ?></p>
					<p><?php echo get_field("service_description", $homepage_id); ?></p>
				</div>
				<?php if (!empty($all_terms) && !is_wp_error($all_terms)) : ?>
				    <div id="homepage-service-categories" class="categories">
				        <span class="categories__item filter" data-filter="all"><?php pll_e("Všechny"); ?></span>
				        <?php foreach ($all_terms as $term) : ?>
				            <span class="categories__item filter" data-filter=".<?php echo esc_attr($term->slug); ?>">
				                <?php echo esc_html($term->name); ?>
				            </span>
				        <?php endforeach; ?>
				    </div>
				    <div id="homepage-services-list" class="trigger"></div>
				<?php endif; ?>
				
				<div class="anchor"></div>

				<?php if ( $services->have_posts() ) : $i = 0; ?>
					<div id="mixitup-services" class="grid">
				        <?php while ( $services->have_posts() ) : $services->the_post(); ?>
				        	<?php 
				                $terms = get_the_terms(get_the_ID(), 'service_cat');
				                $term_names = $terms && !is_wp_error($terms) ? wp_list_pluck($terms, 'name') : [];
				                $term_slugs = $terms && !is_wp_error($terms) ? wp_list_pluck($terms, 'slug') : [];
				                $category_classes = !empty($term_slugs) ? implode(' ', $term_slugs) : 'no-category';
				                $label_text = !empty($term_names) ? implode(', ', $term_names) : 'Bez kategorie';
			                ?>
							<a href="<?php the_permalink(); ?>" class="mix grid__item <?php echo esc_attr($category_classes); ?>" aria-label="<?php echo get_the_title(); ?>">
								<span class="content">
									<span class="top">
										<span class="label"><?php echo esc_html($label_text); ?></span>
										<h2 class="h3 alt"><?php echo get_field("nadpis_nadpis"); ?></h2>
										<?php if ( get_field("logo") ): ?>
											<?php echo Img::img(get_field("logo")["id"], [ get_field("logo")["width"], get_field("logo")["height"] ], false, ['alt' => false, 'class' => false]); ?>
										<?php endif ?>
									</span>
									<span class="button button--primary"><?php pll_e("Více o službě"); ?></span>
								</span>
							</a>
							
				        <?php endwhile; ?>
				        <?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php get_template_part("components/flexible-blocks"); ?>

	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
