<?php get_header(); ?>

<?php 
	$current_language = pll_current_language();
    $_other_articles = array(
        'post_type' => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'post__not_in' => array( get_the_ID() ),
        'lang' => $current_language
    );
    $other_articles = new WP_Query($_other_articles);
?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="reference">

		<div class="reference__content">
			<div class="container">
				<div class="inner">
					<div class="inner__left">
						<h1 class="h2"><?php the_title() ?></h1>
						<?php the_content() ?>
					</div>
					<div class="inner__right">
						<div class="sticky">
							<span class="date"><?php echo get_the_date('d. m. Y'); ?></span>
							<span class="reading-time"><?php echo get_reading_time(get_the_ID()) . ' min. čtení'; ?></span>
							<span class="button button--primary" data-share-link="<?php the_permalink(); ?>" data-share-title="<?php echo get_the_title(); ?>">Sdílet</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		
		<?php if ( $other_articles->have_posts() ) : $i = 0; ?>

			<div class="reference__others">
				<div class="container">
					<h2 class="h2"><?php pll_e("Mohlo by se vám líbit"); ?></h2>
					<div class="references-list">
			            <?php while ( $other_articles->have_posts() ) : $other_articles->the_post(); ?>

			            	<div class="references-list__item">
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
							</div>
						    <?php wp_reset_postdata(); ?>
			            <?php endwhile; ?>
			        </div>
				</div>
			</div>
        <?php endif; ?>
		
	</div>

	<script id="share-link-template" type="x-tmpl-mustache">
		<div class="share-link-modal" id="share-link" style="display: none;">
			<p class="h3">Sdílet</p>
			<ul class="share-link-icons">
				<li>
					<a href="https://www.linkedin.com/sharing/share-offsite/?url={{linkEncoded}}" target="_blank" rel="noreferrer noopener">
						<i class="fa-brands fa-linkedin-in"></i>
						<p>LinkedIn</p>
					</a>
				</li>
				<li>
					<a href="https://www.facebook.com/sharer/sharer.php?u={{linkEncoded}}" target="_blank" rel="noreferrer noopener">
						<i class="fa-brands fa-facebook"></i>
						<p>Facebook</p>
					</a>
				</li>
				<li>
					<a href="https://twitter.com/share?text={{titleEncoded}}&url={{linkEncoded}}" target="_blank" rel="noreferrer noopener">
						<i class="fa-brands fa-x-twitter"></i>
						<p>X (Twitter)</p>
					</a>
				</li>
				<li>
					<a href="mailto:?subject={{titleEncoded}}&body={{link}}" target="_blank">
						<i class="fa-regular fa-envelope"></i>
						<p>E-mail</p>
					</a>
				</li>
			</ul>

			<div class="share-link-copy">
				<input type="text" id="share-link-copy-input" value="{{link}}" readonly>
				<button data-clipboard-target="#share-link-copy-input"><i class="fa-regular fa-copy"></i></button>
			</div>
		</div>
	</script>

<?php endwhile; ?>

<?php get_footer(); ?>
